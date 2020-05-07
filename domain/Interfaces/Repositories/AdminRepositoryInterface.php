<?php


namespace Domain\Interfaces\Repositories;


use Domain\Entities\Admin;

interface AdminRepositoryInterface
{
    public function persist(Admin $admin): void;
    public function update(): void;
    public function findById($id): Admin;
}
