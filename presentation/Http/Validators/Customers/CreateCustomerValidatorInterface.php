<?php


namespace Presentation\Http\Validators\Customers;


interface CreateCustomerValidatorInterface
{
    public function validate($all, array $rules, array $messages): void;
}
