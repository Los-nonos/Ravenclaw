<?php


namespace Infrastructure\Payments;


use Application\Services\Payments\MercadoPagoService;
use Domain\ValueObjects\Payment;
use Infrastructure\Payments\Interfaces\PaymentGateway;

class MercadoPagoGateway implements PaymentGateway
{
    private MercadoPagoService $mercadoPagoService;

    public function __construct(MercadoPagoService $mercadoPagoService)
    {
        $this->mercadoPagoService = $mercadoPagoService;
    }

    public function process(Payment $payment): Payment
    {
        $payment = $this->mercadoPagoService->execute($payment);

        return $payment;
    }
}
