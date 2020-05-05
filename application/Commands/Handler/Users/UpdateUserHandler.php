<?php


namespace Application\Commands\Handler\Users;

use Application\Commands\Command\Users\UpdateUserCommand;
use Application\Services\Users\UserServiceInterface;
use Infrastructure\CommandBus\Handler\HandlerInterface;

class UpdateUserHandler implements HandlerInterface
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function handle(UpdateUserCommand $command): void
    {
        $user = $this->userService->findUserByIdOrFail($command->getId());

        $user->setName($command->getName());
        $user->setSurname($command->getSurname());
        $user->setUsername($command->getUsername());
        $user->setEmail($command->getEmail());

        $this->userService->persist($user);
    }
}
