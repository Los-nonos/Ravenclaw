<?php


namespace Presentation\Http\Validators\Schemas\Customer;


class IndexCustomerSchema
{
    public function getRules(): array {
        return [
            'page' => 'bail|integer|min:0',
            'size' => 'bail|integer|min:0',
            'name' => 'bail|alpha',
            'surname' => 'bail|alpha',
            'username' => 'bail',
            'email' => 'bail|email',
            'organization_name' => 'bail|alpha',
            'domain' => 'bail',
        ];
    }
}
