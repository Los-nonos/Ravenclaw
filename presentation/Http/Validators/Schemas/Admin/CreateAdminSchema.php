<?php


namespace Presentation\Http\Validators\Schemas\Admin;


class CreateAdminSchema
{
    public function getRules(): array {
        return [
            'name' => 'bail|required|alpha',
            'surname' => 'bail|required|alpha',
            'username' => 'bail|required',
            'email' => 'bail|required|email',
            'password' => 'bail|required|min:8|max:15',
            'role' => 'bail|required|alpha'
        ];
    }
}
