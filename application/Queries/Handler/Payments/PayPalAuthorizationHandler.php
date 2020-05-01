<?php


namespace Application\Queries\Handler\Payments;

use Application\Queries\Results\Payments\PaypalAuthorizationResult;
use Application\Services\Customer\CustomerServiceInterface;
use Application\Services\Payments\PaypalServiceInterface;
use Infrastructure\QueryBus\Handler\HandlerInterface;

class PayPalAuthorizationHandler implements HandlerInterface
{
    private PaypalServiceInterface $service;
    private PaypalAuthorizationResult $result;
    private CustomerServiceInterface $customerService;

    public function __construct(PaypalServiceInterface $paypalService, CustomerServiceInterface $customerService, PaypalAuthorizationResult $result)
    {
        $this->service = $paypalService;
        $this->customerService = $customerService;
    }

    public function handle($command): void
    {
        $customer = $this->customerService->findCustomerByIdOrFail($command->getCustomerId());

        $payment = $this->service->Authorization($customer, $command->getAmount());

        $this->result->setPayment($payment);
        //return $this->result;
    }
}
