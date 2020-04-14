<?php


namespace Presentation\Http\Validators\Payments;


interface PaypalExecuteValidatorInterface
{
    public function Validate($all, array $rules, array $messages);
}
