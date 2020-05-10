<?php


namespace Domain\Interfaces\Repositories;


use Domain\Entities\Admin;

interface AdminRepositoryInterface
{
    public function persist(Admin $admin): void;
    public function update(): void;

    /**
     * @param $id
     * @return Admin
     */
    public function findById($id);
}
