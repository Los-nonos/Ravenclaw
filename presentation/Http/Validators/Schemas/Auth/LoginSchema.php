<?php


namespace Presentation\Http\Validators\Schemas\Auth;


class LoginSchema
{
    public function getRules(): array {
        return [
            'username' => 'bail|required|string|alpha',
            'password' => 'bail|required|string|min:8|max:25',
        ];
    }
}
