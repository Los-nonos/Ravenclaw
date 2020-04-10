<?php


namespace Presentation\Http\Actions\Customers;

use Domain\CommandBus\CommandBusInterface;
use Illuminate\Http\Request;
use Presentation\Http\Adapters\Customers\CreateCustomerAdapter;

class CreateCustomerAction
{
    private CreateCustomerAdapter $adapter;

    private CommandBusInterface $commandBus;

    public function __construct(CreateCustomerAdapter $adapter, CommandBusInterface $commandBus)
    {
        $this->adapter = $adapter;
        $this->commandBus = $commandBus;
    }


    public function execute(Request $request)
    {
        $command = $this->adapter->from($request);

        $result = $this->commandBus->handle($command);

        return ['result' => $result];
    }
}
