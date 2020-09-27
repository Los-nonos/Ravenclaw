<?php


namespace Infrastructure\Payments\Services;


use Application\Exceptions\FailedPaymentException;
use Application\Exceptions\InvalidServicePaymentException;
use Application\Exceptions\PaypalClientNotDefined;
use Domain\Entities\Customer;
use Domain\Enums\State;
use Domain\ValueObjects\Payment;
use Money\Money;
use Paypal\Core\PaypalHttpClient;
use Paypal\v1\Payments\PaymentCreateRequest;
use Paypal\v1\Payments\PaymentExecuteRequest;
use Paypal\Core\SandboxEnvironment;
use Paypal\Core\ProductionEnvironment;

class PaypalService
{
    private PaypalHttpClient $client;

    /**
     * @param Payment $payment
     * @return Payment
     * @throws InvalidServicePaymentException
     * @throws FailedPaymentException|PaypalClientNotDefined
     */
    public function execute(Payment $payment): Payment
    {
        if($this->client == null)
        {
            $this->createClient($payment->getAuthorization(), $payment->getAccessToken());
        }

        if($payment->getGateway() !== 'paypal')
        {
            throw new InvalidServicePaymentException();
        }

        $paymentExecute = new PaymentExecuteRequest($payment->getPaymentId());

        $paymentExecute->body = [
            'payer_id' => $payment->getPayerId(),
        ];

        $response = $this->client->execute($paymentExecute);

        if($response->statusCode == 200) {
            $payment->setLastStatus(State::APPROVED);
            $payment->setApprovedDate($response->result['date']);
            $payment->setResponseData($response->result);

            return $payment;
        }
        else {
            throw new FailedPaymentException(json_encode($response->result));
        }
    }

    /**
     * @param Customer $customer
     * @param Money $amount
     * @return Payment
     * @throws FailedPaymentException
     */
    public function Authorization(Customer $customer, Money $amount): Payment
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
                        'total' => $amount->getAmount(),
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

        return new Payment($amount, $redirectLinks[0]->href, $customer->getId(), 'paypal');
    }

    /**
     * @param string $clientId
     * @param string $access_token
     * @throws PaypalClientNotDefined
     */
    public function createClient(?string $clientId, ?string $access_token): void
    {
        if(empty($clientId)) {
            throw new PaypalClientNotDefined("Client id not defined");
        }

        if (env('APP_ENV') === 'production'){
            $environment = new ProductionEnvironment($clientId, $access_token);
        }else {
            $environment = new SandboxEnvironment($clientId, $access_token);
        }

        $this->client = new PaypalHttpClient($environment);
    }
}
