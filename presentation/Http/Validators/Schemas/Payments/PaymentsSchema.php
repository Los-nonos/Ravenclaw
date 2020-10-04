<?php


namespace Presentation\Http\Validators\Schemas\Payments;


class PaymentsSchema
{
  public static function getRules() {
    return [
      'token' => 'bail|required',
      'bin' => 'bail|required|digits:6',
      'associatedId' => 'bail|required|min:0|integer',
      'couponId' => 'bail|required|min:0|integer',
      'gateway' => 'bail|nullable'
    ];
  }

  public static function getAuthorizationRules() {
    return [
      'name' => 'bail|required|min:3',
      'expirationMonth' => 'bail|required|digits:2',
      'expirationYear' => 'bail|required|digits:2',
      'securityCode' => 'bail|required|integer|digits:3',
      'cardNumber' => 'bail|required|integer|digits:16',
      'identification' => 'bail|required|min:7|max:8',
      'gateway' => 'bail|nullable'
    ];
  }
}
