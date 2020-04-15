<?php


namespace Presentation\Http\Validators\Payments;


interface MercadoPagoExecuteValidatorInterface
{
    public function Validate($all, array $rules, array $messages);
}
