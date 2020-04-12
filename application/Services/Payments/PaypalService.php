<?php


namespace Application\Services;


use Application\Exceptions\FailedPaymentException;
use Application\Exceptions\InvalidServicePaymentException;
use Domain\Entities\Customer;
use Domain\Entities\Order;

use Domain\Entities\Payment;
use Illuminate\Support\Facades\Config;
use Paypal\Core\PaypalHttpClient;
use Paypal\v1\Payments\PaymentCreateRequest;
use Paypal\v1\Payments\PaymentExecuteRequest;
use Paypal\Core\SandboxEnvironment;
use Paypal\Core\ProductionEnvironment;

class PaypalService implements PaymentGatewayInterface, PaymentGatewayAuthorizationInterface
{
    private PaypalHttpClient $client;
    private SandboxEnvironment $enviroment;

    public function __construct()
    {
        $clientId = Config::get('services.paypal.clientId');
        $secret = Config::get('services.paypal.secret');

        $this->enviroment = new SandboxEnvironment($clientId, $secret);

        $this->client = new PaypalHttpClient($this->enviroment);
    }

    /**
     * @param Payment $payment
     * @throws InvalidServicePaymentException
     * @throws FailedPaymentException
     */
    public function execute(Payment $payment)
    {
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
            //create new order and return
        }
        else{
            throw new FailedPaymentException();
        }
    }

    public function Authorization(Customer $customer, int $amount): Payment
    {
        $request = new PaymentCreateRequest();

        $request->body = [
            'intent' => 'sale',
            'transactions' => [
                [
                    'amount' => [
                        'total' => $amount,
                        'currency' => 'USD'
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
}
