<?php


namespace Presentation\Http\Validators\Payments;


interface PaypalAuthorizationValidatorInterface
{
    public function Validate($all, array $rules, array $messages);
}
