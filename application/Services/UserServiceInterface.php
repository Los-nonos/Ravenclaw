<?php


namespace Application\Services;


use Application\Commands\Users\CreateUserCommand;
use Domain\Entities\User;

interface UserServiceInterface
{
    public function CreateUserByCommand(CreateUserCommand $command): User;
    public function Persist(User $user): void;
}
