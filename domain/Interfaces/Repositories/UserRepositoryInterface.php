<?php


namespace Domain\Interfaces\Repositories;


use Domain\Entities\User;

interface UserRepositoryInterface
{
    public function save(User $customer): void;
    public function update(): void;
    public function getById(int $userId): ?User;
    public function getByTheEmail(string $email): ?User;
    public function existWithTheEmail(string $email): bool;
    public function all(): array;
    public function delete(User $user): void;
    public function getByUsername(string $username): User;
}
