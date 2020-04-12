<?php


namespace Presentation\Http\Actions\Admins;


use Domain\CommandBus\CommandBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Presentation\Http\Adapters\Admins\CreateAdminAdapter;
use Presentation\Http\Enums\HttpCodes;
use Presentation\Interfaces\Admins\CreateAdminPresenterInterface;

class CreateAdminAction
{
    private CreateAdminAdapter $adapter;
    private CommandBusInterface $commandBus;
    private CreateAdminPresenterInterface $presenter;

    public function __construct(CreateAdminAdapter $adapter, CommandBusInterface $commandBus, CreateAdminPresenterInterface $presenter)
    {
        $this->adapter = $adapter;
        $this->commandBus = $commandBus;
        $this->presenter = $presenter;
    }

    public function execute(Request $request)
    {
        $command = $this->adapter->from($request);

        $result = $this->commandBus->handle($command);

        return new JsonResponse($this->presenter->fromResult($result)->getData(), HttpCodes::CREATED);
    }
}
