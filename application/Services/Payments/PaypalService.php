<?php


namespace Application\Services;


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

class PaypalService implements PaymentGateway, PaymentGatewayAuthorization
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
     * @param Order $order
     * @throws InvalidServicePaymentException
     */
    public function execute(Payment $payment, Order $order)
    {
        if(!$payment->getType() == 'paypal')
        {
            throw new InvalidServicePaymentException();
        }

        $this->client->execute($payment->getAuthorization());
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

        return new Payment($request, $amount, $customer->getId(), 'paypal');
    }
}
