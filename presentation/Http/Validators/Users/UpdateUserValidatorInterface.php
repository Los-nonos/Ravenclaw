<?php


namespace Presentation\Http\Validators\Users;


interface UpdateUserValidatorInterface
{
    public function validate($all, array $rules, array $messages): void;
}
