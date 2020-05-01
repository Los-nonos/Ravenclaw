<?php


namespace Presentation\Http\Actions\Payments;

use App\Exceptions\InvalidBodyException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Infrastructure\QueryBus\QueryBusInterface;
use Presentation\Http\Adapters\Payments\PaypalExecuteAdapter;
use Presentation\Http\Enums\HttpCodes;
use Presentation\Http\Presenters\Payments\PaypalExecutePresenter;

class PaypalExecuteAction
{
    private PaypalExecuteAdapter $adapter;

    private QueryBusInterface $queryBus;

    private PaypalExecutePresenter $presenter;

    public function __construct(
        PaypalExecuteAdapter $adapter,
        QueryBusInterface $queryBus,
        PaypalExecutePresenter $presenter)
    {
        $this->adapter = $adapter;
        $this->queryBus = $queryBus;
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

        $result = $this->queryBus->handle($command);

        return new JsonResponse($this->presenter->fromResult($result)->getData(), HttpCodes::OK);
    }
}
