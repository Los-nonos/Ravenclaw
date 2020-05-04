<?php


namespace Presentation\Http\Validators\Schemas\Admin;


class ShowAdminByIdSchema
{
    public function getRules(): array{
        return [
            'id' => 'bail|required|integer|min:0'
        ];
    }
}
