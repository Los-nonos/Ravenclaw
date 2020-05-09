<?php


namespace Presentation\Http\Actions\Customers;

use App\Exceptions\InvalidBodyException;
use Infrastructure\CommandBus\CommandBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Presentation\Http\Adapters\Customers\CreateCustomerAdapter;
use Presentation\Http\Enums\HttpCodes;
use Presentation\Http\Presenters\Customers\CreateCustomerPresenter;

class CreateCustomerAction
{
    private CreateCustomerAdapter $adapter;

    private CommandBusInterface $commandBus;

    private CreateCustomerPresenter $presenter;

    public function __construct(CreateCustomerAdapter $adapter, CommandBusInterface $commandBus, CreateCustomerPresenter $presenter)
    {
        $this->adapter = $adapter;
        $this->commandBus = $commandBus;
        $this->presenter = $presenter;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidBodyException
     */
    public function __invoke(Request $request)
    {
        $command = $this->adapter->from($request);

        $this->commandBus->handle($command);

        return new JsonResponse(
            $this->presenter->getData(),
            HttpCodes::CREATED
        );
    }
}
