<?php


namespace Application\Commands\Handler\Users;

use Application\Commands\Command\Users\UpdateUserCommand;
use Application\Commands\Results\Users\UpdateUserResult;
use Application\Services\Users\UserServiceInterface;
use Infrastructure\CommandBus\Handler\HandlerInterface;

class UpdateUserHandler implements HandlerInterface
{
    private UserServiceInterface $userService;
    private UpdateUserResult $result;

    public function __construct(UserServiceInterface $userService, UpdateUserResult $result)
    {
        $this->userService = $userService;
        $this->result = $result;
    }

    public function handle(UpdateUserCommand $command): void
    {
        $user = $this->userService->FindUserById($command->getId());

        $user->setName($command->getName());
        $user->setSurname($command->getSurname());
        $user->setUsername($command->getUsername());
        $user->setEmail($command->getEmail());

        $this->userService->Persist($user);

        $this->result->setUser($user);

        //return $this->result;
    }
}
