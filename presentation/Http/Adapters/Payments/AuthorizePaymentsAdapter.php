<?php


namespace Presentation\Http\Adapters\Payments;


use App\Exceptions\InvalidBodyException;
use Application\Queries\Query\Payments\AuthorizePaymentsQuery;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Schemas\Payments\PaymentsSchema;
use Presentation\Http\Validators\Utils\ValidatorService;

class AuthorizePaymentsAdapter
{
  private ValidatorService $validatorService;

  public function __construct(ValidatorService $validatorService)
  {
    $this->validatorService = $validatorService;
  }

  public function from(Request $request)
  {
    $this->validatorService->make($request->all(), PaymentsSchema::getAuthorizationRules());

    if ($this->validatorService->isFail()) {
      throw new InvalidBodyException($this->validatorService->getErrors());
    }

    $data = $request->all();

    return new AuthorizePaymentsQuery(
      $data['name'],
      $data['expirationMonth'],
      $data['expirationYear'],
      $data['securityCode'],
      $data['cardNumber'],
      $data['identification'],
      array_key_exists('gateway', $data) ? $data['gateway'] : 'decidir',
    );
  }
}
