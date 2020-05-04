<?php


namespace Application\Queries\Results\Admins;


use Domain\Entities\Admin;
use Infrastructure\QueryBus\Result\ResultInterface;

class ShowAdminByIdResult implements ResultInterface
{
    private Admin $admin;

    public function setAdmin(Admin $admin): void
    {
        $this->admin = $admin;
    }

    public function getAdmin(): Admin
    {
        return $this->admin;
    }
}
