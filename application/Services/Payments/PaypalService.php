<?php


namespace Application\Services\Payments;


use Application\Exceptions\FailedPaymentException;
use Application\Exceptions\InvalidServicePaymentException;
use Application\Services\Payments\PayPalServiceInterface;
use Domain\Entities\Customer;
use Domain\Entities\Order;

use Domain\Entities\Payment;
use Illuminate\Support\Facades\Config;
use Paypal\Core\PaypalHttpClient;
use Paypal\v1\Payments\PaymentCreateRequest;
use Paypal\v1\Payments\PaymentExecuteRequest;
use Paypal\Core\SandboxEnvironment;
use Paypal\Core\ProductionEnvironment;

class PaypalService implements PayPalServiceInterface
{
    private PaypalHttpClient $client;

    /**
     * @param Payment $payment
     * @throws InvalidServicePaymentException
     * @throws FailedPaymentException
     * @return Order
     */
    public function execute(Payment $payment): Order
    {
        if($this->client == null)
        {
            throw new FailedPaymentException('¡client not generated!');
        }

        if(!$payment->getType() == 'paypal')
        {
            throw new InvalidServicePaymentException();
        }

        $paymentExecute = new PaymentExecuteRequest($payment->getPaymentId());

        $paymentExecute->body = [
            'payer_id' => $payment->getPayerId(),
        ];

        $response = $this->client->execute($paymentExecute);

        if($response->statusCode == 200)
        {
            return new Order();
            //create new order and return
        }
        else{
            throw new FailedPaymentException();
        }
    }

    /**
     * @param Customer $customer
     * @param int $amount
     * @return Payment
     * @throws FailedPaymentException
     */
    public function Authorization(Customer $customer, int $amount): Payment
    {
        if($this->client == null)
        {
            throw new FailedPaymentException('¡client not generated!');
        }

        $request = new PaymentCreateRequest();

        $request->body = [
            'intent' => 'sale',
            'transactions' => [
                [
                    'amount' => [
                        'total' => $amount,
                        'currency' => 'ARS'
                    ]
                ]
            ],
            'payer' => [
                'payment_method' => 'paypal'
                //'payment_method' => 'credit_card',
                //'funding_instruments' => [
                //  'number_card' =>
            ],
            'redirect_urls' => [
                'cancel_url' => $customer->getDomain().'/shopping_cart',
                'return_url' => $customer->getDomain().'/thanks',
            ]
        ];

        $response = $this->client->execute($request);

        $redirectLinks = array_filter($response->result->links, function ($link){
            return $link->method == 'REDIRECT';
        });

        $redirectLinks = array_values($redirectLinks);

        return new Payment($redirectLinks[0]->href, $amount, $customer->getId(), 'paypal');
    }

    public function CreateClient(string $clientId, string $access_token): void
    {
        $enviroment = new SandboxEnvironment($clientId, $access_token);

        $this->client = new PaypalHttpClient($enviroment);
    }
}
