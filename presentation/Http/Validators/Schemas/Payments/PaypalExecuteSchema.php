<?php


namespace Presentation\Http\Validators\Schemas\Payments;


class PaypalExecuteSchema
{
    public function getRules(): array {
        return [
            'paymentId' => 'bail|required|alpha',
            'payerId' => 'bail|required|alpha'
        ];
    }
}
