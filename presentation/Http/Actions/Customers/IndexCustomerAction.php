<?php


namespace Presentation\Http\Actions\Customers;

use App\Exceptions\InvalidBodyException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Infrastructure\QueryBus\Query\QueryInterface;
use Infrastructure\QueryBus\QueryBusInterface;
use Presentation\Http\Adapters\Customers\IndexCustomerAdapter;
use Presentation\Http\Enums\HttpCodes;
use Presentation\Http\Presenters\Customers\IndexCustomerPresenter;

class IndexCustomerAction
{
    private IndexCustomerAdapter $adapter;
    private QueryBusInterface $queryBus;
    private IndexCustomerPresenter $presenter;

    public function __construct(IndexCustomerAdapter $adapter, QueryBusInterface $queryBus, IndexCustomerPresenter $presenter)
    {
        $this->adapter = $adapter;
        $this->queryBus = $queryBus;
        $this->presenter = $presenter;
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidBodyException
     */
    public function __invoke(Request $request)
    {
        $command = $this->adapter->from($request);

        $result = $this->queryBus->handle($command);

        return new JsonResponse($this->presenter->fromResult($result)->getData(), HttpCodes::OK);
    }
}
