<?php


namespace Application\Queries\Handler\Payments;

use Application\Queries\Query\Payments\PayPalAuthorizationQuery;
use Application\Queries\Results\Payments\PaypalAuthorizationResult;
use Application\Services\Customer\CustomerServiceInterface;
use Infrastructure\Payments\Services\PaypalService;
use Infrastructure\QueryBus\Handler\HandlerInterface;

class PayPalAuthorizationHandler implements HandlerInterface
{
    private PaypalService $service;
    private PaypalAuthorizationResult $result;
    private CustomerServiceInterface $customerService;

    public function __construct(
        PaypalService $paypalService,
        CustomerServiceInterface $customerService,
        PaypalAuthorizationResult $result
    )
    {
        $this->service = $paypalService;
        $this->customerService = $customerService;
        $this->result = $result;
    }

    /**
     * @param PayPalAuthorizationQuery $command
     * @return PaypalAuthorizationResult
     */
    public function handle($command): PaypalAuthorizationResult
    {
        $customer = $this->customerService->findCustomerByIdOrFail($command->getCustomerId());

        $this->service->createClient($customer->getClientTokenPaypal(), $command->getAccessToken());

        $payment = $this->service->Authorization($customer, $command->getAmount());

        $this->result->setPayment($payment);
        return $this->result;
    }
}
