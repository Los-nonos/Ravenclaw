<?php


namespace Infrastructure\Payments\Services;


use Application\Exceptions\FailedPaymentException;
use Domain\Entities\Order;
use Domain\Enums\State;
use Domain\ValueObjects\Payment;
use Exception;
use MercadoPago\Payment as MercadoPayment;
use MercadoPago\SDK;
use Money\Money;

class MercadoPagoService
{
    private SDK $client;

    /**
     * @param Payment $payment
     * @return Order
     * @throws FailedPaymentException
     * @throws Exception
     */
    public function execute(Payment $payment): Payment
    {
        $mercadoPayment = new MercadoPayment();
        $mercadoPayment->__set('transaction_amount', $payment->getAmount()->getAmount());
        $mercadoPayment->__set('token', $payment->getAuthorization());
        $mercadoPayment->__set('description', 'sale');
        $mercadoPayment->__set('payment_method_id', $payment->getPaymentId());
        $mercadoPayment->__set('payer', [
            'email' => $payment->getPayerId()
        ]);

        $mercadoPayment->save();

        if($mercadoPayment->__get('status')->status === "approved")
        {
            $payment->setResponseData($mercadoPayment->toArray());
            $payment->setApprovedDate($mercadoPayment->__get('date'));
            $payment->setLastStatus(State::APPROVED);

            return $payment;
        }
        else {
            throw new FailedPaymentException('error try payment execute' . json_encode($mercadoPayment->__get('status')));
        }
    }

    public function generatePayment(string $access_token, Money $amount, int $customerId): Payment
    {
        return new Payment($amount, $access_token, $customerId, 'mercadopago');
    }

    public function createClient(string $accessToken): void
    {
        $this->client::setAccessToken($accessToken);
    }
}
