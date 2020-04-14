<?php


namespace Application\Handlers\Payments;


use Application\Commands\Payments\PayPalAuthorizationCommand;
use Application\Results\Payments\PaypalAuthorizationResult;
use Application\Results\Payments\PaypalAuthorizationResultInterface;
use Application\Services\CustomerServiceInterface;
use Application\Services\PaymentGatewayAuthorizationInterface;
use Application\Services\PaypalService;
use Domain\Entities\Payment;

class PayPalAuthorizationHandler
{
    private PaymentGatewayAuthorizationInterface $service;
    private PaypalAuthorizationResult $result;
    private CustomerServiceInterface $customerService;

    public function __construct(PaypalService $paypalService, CustomerServiceInterface $customerService, PaypalAuthorizationResult $result)
    {
        $this->service = $paypalService;
        $this->customerService = $customerService;
    }

    public function handle(PayPalAuthorizationCommand $command): PaypalAuthorizationResultInterface
    {
        $customer = $this->customerService->findCustomerById($command->getCustomerId());

        $payment = $this->service->Authorization($customer, $command->getAmount());

        $this->result->setPayment($payment);
        return $this->result;
    }
}
