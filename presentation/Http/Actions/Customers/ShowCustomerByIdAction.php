<?php


namespace Presentation\Http\Actions\Customers;


use App\Exceptions\InvalidBodyException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Infrastructure\QueryBus\QueryBusInterface;
use Presentation\Http\Adapters\Customers\ShowCustomerByIdAdapter;
use Presentation\Http\Presenters\Customers\ShowCustomerByIdPresenter;

class ShowCustomerByIdAction
{
    private ShowCustomerByIdAdapter $adapter;

    private QueryBusInterface $queryBus;

    private ShowCustomerByIdPresenter $presenter;

    public function __construct(
        ShowCustomerByIdAdapter $adapter,
        QueryBusInterface $queryBus,
        ShowCustomerByIdPresenter $presenter
    )
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
        $query = $this->adapter->from($request);

        $result = $this->queryBus->handle($query);

        return new JsonResponse($this->presenter->fromResult($result)->getData());
    }
}
