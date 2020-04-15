<?php


namespace Presentation\Http\Actions\Payments;


use Domain\CommandBus\CommandBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Presentation\Http\Adapters\Payments\MercadoPagoExecuteAdapter;
use Presentation\Http\Enums\HttpCodes;

class MercadoPagoExecuteAction
{
    private MercadoPagoExecuteAdapter $adapter;

    private CommandBusInterface $commandBus;

    private MercadoPagoExecutePresenter $presenter;

    public function __construct(
        MercadoPagoExecuteAdapter $adapter,
        CommandBusInterface $commandBus,
        MercadoPagoExecutePresenter $presenter
    )
    {
        $this->adapter = $adapter;
        $this->commandBus = $commandBus;
        $this->presenter = $presenter;
    }

    public function execute(Request $request)
    {
        $command = $this->adapter->from($request);

        $result = $this->commandBus->handle($command);

        return new JsonResponse($this->presenter->fromResult($result)->getData(), HttpCodes::OK);
    }
}
