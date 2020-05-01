<?php


namespace Presentation\Http\Actions\Admins;


use App\Exceptions\InvalidBodyException;
use Infrastructure\CommandBus\CommandBusInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Presentation\Http\Adapters\Admins\CreateAdminAdapter;
use Presentation\Http\Enums\HttpCodes;
use Presentation\Http\Presenters\Admins\CreateAdminPresenter;

class CreateAdminAction
{
    private CreateAdminAdapter $adapter;
    private CommandBusInterface $commandBus;
    private CreateAdminPresenter $presenter;

    public function __construct(CreateAdminAdapter $adapter, CommandBusInterface $commandBus, CreateAdminPresenter $presenter)
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

        return new JsonResponse($this->presenter->fromResult($result)->getData(), HttpCodes::CREATED);
    }
}
