<?php


namespace Application\Commands\Handler\Payments;


use Application\Commands\Command\Payments\PayPalAuthorizationCommand;
use Application\Commands\Results\Payments\PaypalAuthorizationResult;
use Application\Commands\Results\Payments\PaypalAuthorizationResultInterface;
use Application\Services\Customers\CustomerServiceInterface;
use Application\Services\PaypalService;
use Infrastructure\CommandBus\Handler\HandlerInterface;

class PayPalAuthorizationHandler implements HandlerInterface
{
    private PaypalService $service;
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
