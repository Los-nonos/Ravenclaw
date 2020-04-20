<?php


namespace Presentation\Http\Actions\Payments;

use Infrastructure\CommandBus\CommandBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Presentation\Http\Adapters\Payments\PaypalExecuteAdapter;
use Presentation\Http\Enums\HttpCodes;
use Presentation\Http\Presenters\Payments\PaypalExecutePresenter;

class PaypalExecuteAction
{
    private PaypalExecuteAdapter $adapter;

    private CommandBusInterface $commandBus;

    private PaypalExecutePresenter $presenter;

    public function __construct(PaypalExecuteAdapter $adapter, CommandBusInterface $commandBus, PaypalExecutePresenter $presenter)
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
