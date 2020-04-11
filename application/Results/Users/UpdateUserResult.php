<?php


namespace Application\Results\Users;


use Domain\Entities\User;

class UpdateUserResult implements UpdateUserResultInterface
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
