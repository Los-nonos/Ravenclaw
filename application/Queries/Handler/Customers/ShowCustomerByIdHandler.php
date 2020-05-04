<?php


namespace Application\Queries\Handler\Customers;


use Application\Queries\Results\Customers\ShowCustomerByIdResult;
use Application\Services\Customer\CustomerServiceInterface;
use Infrastructure\QueryBus\Handler\HandlerInterface;
use Infrastructure\QueryBus\Query\QueryInterface;

class ShowCustomerByIdHandler implements HandlerInterface
{
    private CustomerServiceInterface $customerService;

    private ShowCustomerByIdResult $result;

    public function __construct(CustomerServiceInterface $customerService, ShowCustomerByIdResult $result)
    {
        $this->customerService = $customerService;
        $this->result = $result;
    }

    public function handle(QueryInterface $command): ShowCustomerByIdResult
    {
        $customer = $this->customerService->findCustomerByIdOrFail($command->getId());

        $this->result->setCustomer($customer);
    }
}
