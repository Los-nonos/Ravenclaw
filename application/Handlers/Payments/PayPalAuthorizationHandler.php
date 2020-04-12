<?php


namespace Application\Handlers\Payments;


use Application\Commands\Payments\PayPalAuthorizationCommand;
use Application\Services\PaymentGatewayAuthorizationInterface;
use Application\Services\PaypalService;

class PayPalAuthorizationHandler
{
    private PaymentGatewayAuthorizationInterface $service;

    public function __construct(PaymentGatewayAuthorizationInterface $service)
    {
        $this->service = $service;
    }

    public function handle(PayPalAuthorizationCommand $command)
    {
        
    }
}
