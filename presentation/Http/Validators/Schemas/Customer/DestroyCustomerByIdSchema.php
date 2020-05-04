<?php


namespace Presentation\Http\Validators\Schemas\Customer;


class DestroyCustomerByIdSchema
{
    public function getRules(): array {
        return [
            'id' => 'bail|integer|min:0|required',
            'admin_id' => 'bail|integer|min:0|required'
        ];
    }
}
