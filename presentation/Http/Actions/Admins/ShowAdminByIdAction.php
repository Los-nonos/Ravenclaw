<?php


namespace Presentation\Http\Actions\Admins;


use App\Exceptions\InvalidBodyException;
use Application\Queries\Results\Admins\ShowAdminByIdResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Infrastructure\QueryBus\Exception\InvalidResultException;
use Infrastructure\QueryBus\QueryBusInterface;
use Presentation\Http\Adapters\Admins\ShowAdminByIdAdapter;
use Presentation\Http\Presenters\Admins\ShowAdminByIdPresenter;

class ShowAdminByIdAction
{
    private ShowAdminByIdAdapter $adapter;

    private QueryBusInterface $queryBus;

    private ShowAdminByIdPresenter $presenter;

    public function __construct()
    {

    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidBodyException
     * @throws InvalidResultException
     */
    public function __invoke(Request $request)
    {
        $query = $this->adapter->from($request);

        $result = $this->queryBus->handle($query);

        if(!$result instanceof ShowAdminByIdResult) {
            throw new InvalidResultException("you treating to return once result invalid");
        }
        
        return new JsonResponse($this->presenter->fromResult($result)->getData());
    }
}
