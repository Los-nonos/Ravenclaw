<?php


namespace Infrastructure\Payments\Factories;


use Infrastructure\Payments\Enums\PaymentGateways;
use Infrastructure\Payments\Exceptions\GatewayNotFound;
use Infrastructure\Payments\Interfaces\PaymentGateway;
use Infrastructure\Payments\MercadoPagoGateway;
use Infrastructure\Payments\PaypalGateway;

class PaymentGatewayFactory
{
    private MercadoPagoGateway $mercadoPagoGateway;

    private PaypalGateway $paypalGateway;

    public function __construct(
        MercadoPagoGateway $mercadoPagoGateway,
        PaypalGateway $paypalGateway
    )
    {
        $this->mercadoPagoGateway = $mercadoPagoGateway;
        $this->paypalGateway = $paypalGateway;
    }

    public function create(string $gateway): PaymentGateway
    {
        if ($gateway === PaymentGateways::MERCADO_PAGO) {
            return $this->mercadoPagoGateway;
        }
        if ($gateway === PaymentGateways::PAYPAL) {
            return $this->paypalGateway;
        }

        throw new GatewayNotFound();
    }
}
