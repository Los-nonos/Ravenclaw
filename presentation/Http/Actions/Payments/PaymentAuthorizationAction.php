<?php


namespace Presentation\Http\Actions\Payments;


use Application\Exceptions\InvalidServicePaymentException;
use Domain\CommandBus\CommandBusInterface;
use Illuminate\Http\Request;
use Presentation\Http\Adapters\Payments\PaymentAuthorizationAdapter;

class PaymentAuthorizationAction
{
    private PaymentAuthorizationAdapter $adapter;

    private CommandBusInterface $commandBus;

    private PaymentAuthorizationPresenter $presenter;

    public function __construct(PaymentAuthorizationAdapter $adapter, CommandBusInterface $commandBus, PaymentAuthorizationPresenter $presenter)
    {
        $this->presenter = $presenter;
        $this->adapter = $adapter;
        $this->commandBus = $commandBus;
    }

    /**
     * @param Request $request
     * @throws InvalidServicePaymentException
     */
    public function execute(Request $request)
    {
        $command = $this->adapter->from($request);


    }
}
