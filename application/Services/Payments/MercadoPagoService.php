<?php


namespace Application\Services\Payments;


use Application\Exceptions\FailedPaymentException;
use Domain\Entities\Order;
use Domain\Entities\Payment;
use Exception;
use MercadoPago\Payment as MercadoPayment;
use MercadoPago\SDK;

class MercadoPagoService implements MercadoPagoServiceInterface
{
    private SDK $client;

    /**
     * @param Payment $payment
     * @return Order
     * @throws FailedPaymentException
     * @throws Exception
     */
    public function Execute(Payment $payment): Order
    {
        $mercadoPayment = new MercadoPayment();
        $mercadoPayment->__set('transaction_amount', $payment->getAmount());
        $mercadoPayment->__set('token', $payment->getAuthorization());
        $mercadoPayment->__set('description', 'sale');
        $mercadoPayment->__set('payment_method_id', $payment->getPaymentId());
        $mercadoPayment->__set('payer', [
            'email' => $payment->getPayerId()
        ]);

        $mercadoPayment->save();

        if($mercadoPayment->__get('status')->status === "approved")
        {
            return new Order();
        }
        else {
            throw new FailedPaymentException('error try payment execute' . json_encode($mercadoPayment->__get('status')));
        }
    }

    public function GeneratePayment(string $access_token, int $amount): Payment
    {
        return new Payment($access_token, $amount, 0, 'mercadopago');
    }

    public function CreateClient(string $accessToken): void
    {
        $this->client::setAccessToken($accessToken);
    }
}
