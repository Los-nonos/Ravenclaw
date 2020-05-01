<?php


namespace Presentation\Http\Actions\Payments;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Infrastructure\QueryBus\QueryBusInterface;
use Presentation\Http\Adapters\Payments\MercadoPagoExecuteAdapter;
use Presentation\Http\Enums\HttpCodes;
use Presentation\Http\Presenters\Payments\MercadoPagoExecutePresenter;

class MercadoPagoExecuteAction
{
    private MercadoPagoExecuteAdapter $adapter;

    private QueryBusInterface $queryBus;

    private MercadoPagoExecutePresenter $presenter;

    public function __construct(
        MercadoPagoExecuteAdapter $adapter,
        QueryBusInterface $queryBus,
        MercadoPagoExecutePresenter $presenter
    )
    {
        $this->adapter = $adapter;
        $this->queryBus = $queryBus;
        $this->presenter = $presenter;
    }

    public function __invoke(Request $request)
    {
        $command = $this->adapter->from($request);

        $result = $this->queryBus->handle($command);

        return new JsonResponse($this->presenter->fromResult($result)->getData(), HttpCodes::OK);
    }
}
