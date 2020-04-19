<?php


namespace Application\Commands\Results\Admins;


use Domain\Entities\User;

interface CreateAdminResultInterface
{
    public function setUser(User $user): void;
    public function getUser(): User;
}
