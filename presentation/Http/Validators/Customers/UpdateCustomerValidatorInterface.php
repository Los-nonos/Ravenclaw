<?php


namespace Presentation\Http\Validators\Customers;


interface UpdateCustomerValidatorInterface
{
    public function validate($all, array $rules, array $messages): void;
}
