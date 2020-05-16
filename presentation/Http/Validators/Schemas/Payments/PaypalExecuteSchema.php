<?php


namespace Presentation\Http\Validators\Schemas\Payments;


class PaypalExecuteSchema
{
    public function getRules(): array {
        return [
            'payment_id' => 'bail|required',
            'payer_id' => 'bail|required',
            'customer_id' => 'bail|required|integer|min:0',
            'access_token' => 'bail|required'
        ];
    }
}
