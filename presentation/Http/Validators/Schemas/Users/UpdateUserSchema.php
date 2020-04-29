<?php


namespace Presentation\Http\Validators\Schemas\Users;


class UpdateUserSchema
{
    public function getRules(): array {
        return [
            'id' => 'bail|required|min:0|integer',
            'name' => 'bail|required|alpha',
            'surname' => 'bail|required|alpha',
            'username' => 'bail|required',
            'email' => 'bail|required|email',
        ];
    }
}
