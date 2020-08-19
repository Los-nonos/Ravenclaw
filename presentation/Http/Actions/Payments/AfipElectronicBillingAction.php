<?php


namespace Presentation\Http\Actions\Payments;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Infrastructure\CommandBus\CommandBusInterface;
use Infrastructure\QueryBus\QueryBusInterface;
use Presentation\Http\Adapters\Payments\AfipElectronicBillingAdapter;
use Presentation\Http\Enums\HttpCodes;
use Presentation\Http\Presenters\Payments\AfipElectronicBillingPresenter;

class AfipElectronicBillingAction
{
    /**
     * @var AfipElectronicBillingAdapter
     */
    private AfipElectronicBillingAdapter $adapter;

    private QueryBusInterface $queryBus;

    private AfipElectronicBillingPresenter $presenter;

    public function __construct(
        AfipElectronicBillingAdapter $adapter,
        QueryBusInterface $queryBus,
        AfipElectronicBillingPresenter $presenter
    ) {
        $this->adapter = $adapter;
        $this->queryBus = $queryBus;
        $this->presenter = $presenter;
    }

    public function __invoke(Request $request)
    {
        $query = $this->adapter->from($request);

        $result = $this->queryBus->handle($query);

        return new JsonResponse(['data' => $this->presenter->fromResult($result)->getData()], HttpCodes::OK);
    }
}
