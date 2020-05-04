<?php


namespace Presentation\Http\Actions\Payments;


use App\Exceptions\InvalidBodyException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Infrastructure\QueryBus\QueryBusInterface;
use Presentation\Http\Adapters\Payments\PaypalAuthorizationAdapter;
use Presentation\Http\Enums\HttpCodes;
use Presentation\Http\Presenters\Payments\PaypalAuthorizationPresenter;

class PaypalAuthorizationAction
{
    private PaypalAuthorizationAdapter $adapter;

    private QueryBusInterface $queryBus;

    private PaypalAuthorizationPresenter $presenter;

    public function __construct(
        PaypalAuthorizationAdapter $adapter,
        QueryBusInterface $queryBus,
        PaypalAuthorizationPresenter $presenter)
    {
        $this->presenter = $presenter;
        $this->adapter = $adapter;
        $this->queryBus = $queryBus;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws InvalidBodyException
     */
    public function __invoke(Request $request)
    {
        $command = $this->adapter->from($request);

        $result = $this->queryBus->handle($command);

        return new JsonResponse($this->presenter->fromResult($result)->getData(), HttpCodes::OK);
    }
}
