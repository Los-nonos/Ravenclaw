<?php


namespace Presentation\Http\Actions\Payments;


use App\Exceptions\InvalidBodyException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Infrastructure\QueryBus\QueryBusInterface;
use Presentation\Http\Adapters\Payments\AuthorizePaymentsAdapter;
use Presentation\Http\Enums\HttpCodes;

class AuthorizePaymentsAction
{
  private QueryBusInterface $queryBus;
  private AuthorizePaymentsAdapter $adapter;

  public function __construct(
    QueryBusInterface $queryBus,
    AuthorizePaymentsAdapter $adapter
  ) {
    $this->queryBus = $queryBus;
    $this->adapter = $adapter;
  }

  /**
   * Execute the concrete action
   * @param Request $request
   * @return JsonResponse
   * @throws InvalidBodyException
   */
  public function __invoke(Request $request)
  {
    $query = $this->adapter->from($request);

    $result = $this->queryBus->handle($query);

    return new JsonResponse(['data' => $result->getData() ], HttpCodes::OK);
  }
}
