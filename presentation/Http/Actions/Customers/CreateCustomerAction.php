<?php


namespace Presentation\Http\Actions\Customers;

use Domain\CommandBus\CommandBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Presentation\Http\Adapters\Customers\CreateCustomerAdapter;
use Presentation\Http\Enums\HttpCodes;
use Presentation\Interfaces\Customers\CreateCustomerPresenterInterface;

class CreateCustomerAction
{
    private CreateCustomerAdapter $adapter;

    private CommandBusInterface $commandBus;

    private CreateCustomerPresenterInterface $presenter;

    public function __construct(CreateCustomerAdapter $adapter, CommandBusInterface $commandBus, CreateCustomerPresenterInterface $presenter)
    {
        $this->adapter = $adapter;
        $this->commandBus = $commandBus;
        $this->presenter = $presenter;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function execute(Request $request)
    {
        $command = $this->adapter->from($request);

        $result = $this->commandBus->handle($command);

        return new JsonResponse(
            $this->presenter->fromResult($result)->getData(),
            HttpCodes::CREATED
        );
    }
}
