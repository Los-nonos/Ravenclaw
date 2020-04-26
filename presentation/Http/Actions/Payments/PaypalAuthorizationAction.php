<?php


namespace Presentation\Http\Actions\Payments;


use Application\Exceptions\InvalidServicePaymentException;
use Infrastructure\CommandBus\CommandBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Presentation\Http\Adapters\Payments\PaypalAuthorizationAdapter;
use Presentation\Http\Enums\HttpCodes;
use Presentation\Http\Presenters\Payments\PaypalAuthorizationPresenter;

class PaypalAuthorizationAction
{
    private PaypalAuthorizationAdapter $adapter;

    private CommandBusInterface $commandBus;

    private PaypalAuthorizationPresenter $presenter;

    public function __construct(PaypalAuthorizationAdapter $adapter, CommandBusInterface $commandBus, PaypalAuthorizationPresenter $presenter)
    {
        $this->presenter = $presenter;
        $this->adapter = $adapter;
        $this->commandBus = $commandBus;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidServicePaymentException
     */
    public function execute(Request $request)
    {
        $command = $this->adapter->from($request);

        $result = $this->commandBus->handle($command);

        return new JsonResponse($this->presenter->fromResult($result)->getData(), HttpCodes::OK);
    }
}
