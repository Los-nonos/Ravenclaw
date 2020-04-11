<?php


namespace Application\Handlers\Users;

use Application\Commands\Users\UpdateUserCommand;
use Application\Results\Users\UpdateUserResultInterface;
use Application\Services\UserServiceInterface;

class UpdateUserHandler
{
    private UserServiceInterface $userService;
    private UpdateUserResultInterface $result;

    public function __construct(UserServiceInterface $userService, UpdateUserResultInterface $result)
    {
        $this->userService = $userService;
        $this->result = $result;
    }

    public function handle(UpdateUserCommand $command): UpdateUserResultInterface
    {
        $user = $this->userService->FindUserById($command->getId());

        $user->setName($command->getName());
        $user->setSurname($command->getSurname());
        $user->setUsername($command->getUsername());
        $user->setEmail($command->getEmail());

        $this->userService->Persist($user);

        $this->result->setUser($user);

        return $this->result;
    }
}
