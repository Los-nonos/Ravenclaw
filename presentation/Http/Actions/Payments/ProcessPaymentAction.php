<?php


namespace Presentation\Http\Actions\Payments;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Infrastructure\CommandBus\CommandBusInterface;
use Presentation\Http\Adapters\Payments\ProcessPaymentsAdapter;
use Presentation\Http\Enums\HttpCodes;

class ProcessPaymentAction
{
  private CommandBusInterface $commandBus;
  private ProcessPaymentsAdapter $adapter;

  public function __construct(
    CommandBusInterface $commandBus,
    ProcessPaymentsAdapter $adapter
  ) {
    $this->commandBus = $commandBus;
    $this->adapter = $adapter;
  }

  public function __invoke(Request $request)
  {
    $query = $this->adapter->from($request);

    $this->commandBus->handle($query);

    return new JsonResponse(['message' => 'Pago procesado con éxito' ], HttpCodes::OK);
  }
}
