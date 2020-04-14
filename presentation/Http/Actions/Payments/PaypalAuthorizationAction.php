<?php


namespace Presentation\Http\Actions\Payments;


use Application\Exceptions\InvalidServicePaymentException;
use Domain\CommandBus\CommandBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Presentation\Http\Adapters\Payments\PaypalAuthorizationAdapter;
use Presentation\Http\Enums\HttpCodes;
use Presentation\Interfaces\Payments\PaypalAuthorizationPresenterInterface;

class PaypalAuthorizationAction
{
    private PaypalAuthorizationAdapter $adapter;

    private CommandBusInterface $commandBus;

    private PaypalAuthorizationPresenterInterface $presenter;

    public function __construct(PaypalAuthorizationAdapter $adapter, CommandBusInterface $commandBus, PaypalAuthorizationPresenterInterface $presenter)
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
