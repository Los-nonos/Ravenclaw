<?php


namespace Application\Results\Admins;


use Domain\Entities\User;

class CreateAdminResult implements CreateAdminResultInterface
{
    private User $user;

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
