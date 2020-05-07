<?php


namespace Presentation\Http\Validators\Schemas;


class RenewTokenSchema
{
    public function getRules(): array
    {
        return [
            'token' => 'bail|required|between:150,500',
        ];
    }
}
