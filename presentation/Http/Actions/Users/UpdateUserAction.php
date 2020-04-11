<?php


namespace Presentation\Http\Actions\Users;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Domain\CommandBus\CommandBusInterface;
use Presentation\Http\Adapters\Users\UpdateUserAdapter;
use Presentation\Http\Enums\HttpCodes;
use Presentation\Interfaces\Users\UpdateUserPresenterInterface;

class UpdateUserAction
{
    private UpdateUserAdapter $adapter;
    private CommandBusInterface $commandBus;
    private UpdateUserPresenterInterface $presenter;

    public function __construct(UpdateUserAdapter $adapter, CommandBusInterface $commandBus, UpdateUserPresenterInterface $presenter)
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
