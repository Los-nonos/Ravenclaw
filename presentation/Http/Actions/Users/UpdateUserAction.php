<?php


namespace Presentation\Http\Actions\Users;

use App\Exceptions\InvalidBodyException;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Infrastructure\CommandBus\CommandBusInterface;
use Presentation\Http\Adapters\Users\UpdateUserAdapter;
use Presentation\Http\Enums\HttpCodes;
use Presentation\Http\Presenters\Users\UpdateUserPresenter;

class UpdateUserAction
{
    private UpdateUserAdapter $adapter;
    private CommandBusInterface $commandBus;
    private UpdateUserPresenter $presenter;

    public function __construct(UpdateUserAdapter $adapter, CommandBusInterface $commandBus, UpdateUserPresenter $presenter)
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

        $result = $this->commandBus->handle($command);

        return new JsonResponse($this->presenter->fromResult($result)->getData(), HttpCodes::OK);
    }
}
