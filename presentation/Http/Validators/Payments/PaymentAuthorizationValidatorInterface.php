<?php


namespace Presentation\Http\Validators\Payments;


interface PaymentAuthorizationValidatorInterface
{
    public function Validate($all, array $rules, array $messages);
}
