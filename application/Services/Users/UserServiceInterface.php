<?php


namespace Application\Services\Users;


use Application\Commands\Command\Users\CreateUserCommand;
use Domain\Entities\User;

interface UserServiceInterface
{
    public function createUserByCommand(CreateUserCommand $command): User;
    public function persist(User $user): void;
    public function findUserByIdOrFail(int $id): ?User;
    public function findUserByUsernameOrFail(string $username): User;
}
