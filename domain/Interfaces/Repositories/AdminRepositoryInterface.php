<?php


namespace Domain\Interfaces\Repositories;


use Domain\Entities\Admin;

interface AdminRepositoryInterface
{
    public function Persist(Admin $admin): void;
    public function Update(): void;
    public function FindById($id): Admin;
}
