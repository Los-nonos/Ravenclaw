<?php


namespace Presentation\Http\Validators\Schemas\Customer;


class CreateCustomerSchema
{
    public function getRules(): array {
        return [
            'name' => 'bail|required|alpha',
            'surname' => 'bail|required|alpha',
            'username' => 'bail|required',
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:4|max:16',
            'domain' => 'bail|required',
            'organization_name' => 'bail|required',
        ];
    }
}
