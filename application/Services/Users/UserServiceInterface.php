<?php


namespace Application\Services\Users;


use Application\Commands\Users\CreateUserCommand;
use Domain\Entities\User;

interface UserServiceInterface
{
    public function CreateUserByCommand(CreateUserCommand $command): User;
    public function Persist(User $user): void;
    public function FindUserById(int $id): ?User;
}
