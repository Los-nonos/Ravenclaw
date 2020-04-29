<?php


namespace Application\Commands\Handler\Admins;


use Application\Commands\Command\Admins\CreateAdminCommand;
use Application\Commands\Command\Users\CreateUserCommand;
use Application\Commands\Results\Admins\CreateAdminResult;
use Application\Exceptions\SettingRoleUserNotPermittedException;
use Application\Services\Users\UserServiceInterface;
use Domain\Entities\Admin;
use Domain\Interfaces\Repositories\AdminRepositoryInterface;
use Infrastructure\CommandBus\Handler\HandlerInterface;

class CreateAdminHandler implements HandlerInterface
{
    private UserServiceInterface $userService;
    private CreateAdminResult $result;
    private AdminRepositoryInterface $repository;

    public function __construct(UserServiceInterface $userService, AdminRepositoryInterface $repository, CreateAdminResult $result)
    {
        $this->userService = $userService;
        $this->result = $result;
        $this->repository = $repository;
    }

    public function handle(CreateAdminCommand $command): void
    {
        $user = $this->userService->CreateUserByCommand($this->createUserCommand($command));

        $admin = new Admin($command->getRole());

        try {
            $user->setAdmin($admin);
            $this->repository->Persist($admin);
        } catch (SettingRoleUserNotPermittedException $e) {

        }

        $this->userService->Persist($user);

        $this->result->setUser($user);

        //return $this->result;
    }

    private function createUserCommand(CreateAdminCommand $command): CreateUserCommand
    {
        return new CreateUserCommand($command->getName(), $command->getSurname(), $command->getUsername(), $command->getEmail(), $command->getPassword());
    }
}
