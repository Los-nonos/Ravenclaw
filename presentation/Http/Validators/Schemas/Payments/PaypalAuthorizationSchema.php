<?php


namespace Presentation\Http\Validators\Schemas\Payments;


class PaypalAuthorizationSchema
{
    public function getRules(): array {
        return [
            'customer_id' => 'bail|required|min:0|integer',
            'amount' => 'bail|required|min:0'
        ];
    }
}
