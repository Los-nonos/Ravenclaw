<?php


namespace Presentation\Http\Validators\Schemas\Payments;


class MercadoPagoExecuteSchema
{
    public function getRules(): array {
        return [
            'access_token' => 'bail|required',
            'amount' => 'bail|required|numeric',
            'email_payer' => 'bail|required|email',
            'cart_token' => 'bail|required',
            'payment_method' => 'bail|required',
            'customer_id' => 'bail|required|integer|min:0'
        ];
    }
}
