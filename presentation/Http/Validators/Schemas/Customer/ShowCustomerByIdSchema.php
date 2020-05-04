<?php


namespace Presentation\Http\Validators\Schemas\Customer;


class ShowCustomerByIdSchema
{
    public function getRules(): array
    {
        return [
            'id' => 'bail|integer|required'
        ];
    }
}
