<?php


namespace Presentation\Http\Adapters\Payments;


use App\Exceptions\InvalidBodyException;
use Application\Commands\Command\Payments\ProcessPaymentsCommand;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Schemas\Payments\PaymentsSchema;
use Presentation\Http\Validators\Utils\ValidatorServiceInterface;
use Psr\Http\Message\ServerRequestInterface;

class ProcessPaymentsAdapter
{
  private ValidatorServiceInterface $validatorService;

  public function __construct(ValidatorServiceInterface $validatorService)
  {
    $this->validatorService = $validatorService;
  }

  /**
   * Adapt a http request to an application's layer input
   * @param Request $request
   * @return ProcessPaymentsCommand
   * @throws InvalidBodyException
   */
  public function from(Request $request): ProcessPaymentsCommand
  {
    $this->validatorService->make($request->all(), PaymentsSchema::getRules());

    if ($this->validatorService->isFail()){
      throw new InvalidBodyException($this->validatorService->getErrors());
    }

    $data = $request->all();

    return new ProcessPaymentsCommand(
      $data['token'],
      $data['bin'],
      $data['customerId'],
      array_key_exists('gateway', $data) ? $data['gateway'] : 'decidir',
    );
  }
}
