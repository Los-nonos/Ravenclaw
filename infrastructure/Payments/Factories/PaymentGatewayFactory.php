<?php


namespace Infrastructure\Payments\Factories;


use Infrastructure\Payments\DecidirGateway;
use Infrastructure\Payments\Enums\PaymentGateways;
use Infrastructure\Payments\Exceptions\GatewayNotFound;
use Infrastructure\Payments\Interfaces\AuthorizableGateway;
use Infrastructure\Payments\Interfaces\PaymentGateway;
use Infrastructure\Payments\MercadoPagoGateway;
use Infrastructure\Payments\PaypalGateway;

class PaymentGatewayFactory
{
  private MercadoPagoGateway $mercadoPagoGateway;
  private PaypalGateway $paypalGateway;
  private DecidirGateway $decidirGateway;

  public function __construct(
    MercadoPagoGateway $mercadoPagoGateway,
    PaypalGateway $paypalGateway,
    DecidirGateway $decidirGateway
  )
  {
    $this->mercadoPagoGateway = $mercadoPagoGateway;
    $this->paypalGateway = $paypalGateway;
    $this->decidirGateway = $decidirGateway;
  }

  public function create(string $gateway): PaymentGateway
  {
      if ($gateway === PaymentGateways::MERCADO_PAGO) {
          return $this->mercadoPagoGateway;
      }
      if ($gateway === PaymentGateways::PAYPAL) {
          return $this->paypalGateway;
      }
      if ($gateway === PaymentGateways::DECIDIR) {
        return $this->decidirGateway;
      }

      throw new GatewayNotFound();
  }

  public function createAuthorizable(string $gateway): AuthorizableGateway {

    if ($gateway === PaymentGateways::DECIDIR) {
      return $this->decidirGateway;
    }

    throw new GatewayNotFound();
  }
}
