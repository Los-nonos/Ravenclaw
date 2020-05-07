<?php


namespace Presentation\Http\Actions\Auth;


use App\Exceptions\InvalidBodyException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Infrastructure\QueryBus\QueryBusInterface;
use Presentation\Http\Adapters\Auth\RenewTokenAdapter;
use Presentation\Http\Presenters\Auth\RenewTokenPresenter;

class RenewTokenAction
{
    private RenewTokenAdapter $adapter;

    private QueryBusInterface $queryBus;

    private RenewTokenPresenter $presenter;

    public function __construct(
        RenewTokenAdapter $adapter,
        QueryBusInterface $queryBus,
        RenewTokenPresenter $presenter
    )
    {

    }

    /**
     * @param Request $request
     * @throws InvalidBodyException
     */
    public function __invoke(Request $request)
    {
        $query = $this->adapter->from($request);

        $result = $this->queryBus->handle($query);

        return new JsonResponse(
            $this->presenter->fromResult($result)->getData(),
        );
    }
}
