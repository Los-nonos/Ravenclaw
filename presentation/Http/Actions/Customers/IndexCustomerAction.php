<?php


namespace Presentation\Http\Actions\Customers;

use Application\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Presentation\Http\Adapters\Customers\IndexCustomerAdapter;
use Presentation\Http\Enums\HttpCodes;
use Presentation\Interfaces\Customers\IndexCustomerPresenterInterface;

class IndexCustomerAction
{
    private IndexCustomerAdapter $adapter;
    private CustomerService $service;
    private IndexCustomerPresenterInterface $presenter;

    public function __construct(IndexCustomerAdapter $adapter, CustomerService $service, IndexCustomerPresenterInterface $presenter)
    {
        $this->service = $service;
        $this->adapter = $adapter;
        $this->presenter = $presenter;
    }


    public function execute(Request $request)
    {
        $command = $this->adapter->from($request);

        $result = $this->service->indexCustomers($command);

        return new JsonResponse($this->presenter->fromResult($result)->getData(), HttpCodes::OK);
    }
}
