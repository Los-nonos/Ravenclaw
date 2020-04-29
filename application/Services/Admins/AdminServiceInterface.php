<?php


namespace Application\Services\Admins;


use Domain\Entities\Admin;

interface AdminServiceInterface
{
    public function findAdminByIdOrFail(int $id): Admin;
}
