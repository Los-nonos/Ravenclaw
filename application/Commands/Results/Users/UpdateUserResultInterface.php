<?php


namespace Application\Commands\Results\Users;


use Domain\Entities\User;

interface UpdateUserResultInterface
{
    public function setUser(User $user): void;
    public function getUser(): User;
}
