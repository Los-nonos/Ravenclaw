<?php


namespace Presentation\Http\Validators\Admins;


interface CreateAdminValidatorInterface
{
    public function Validate($all, array $rules, array $messages);
}
