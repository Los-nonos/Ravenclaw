<?php


namespace Domain\Interfaces\Repositories;


use Domain\Entities\User;

interface UserRepositoryInterface
{
    public function save(User $customer): void;
    public function update(): void;
    public function getById(int $userId): ?User;
}
