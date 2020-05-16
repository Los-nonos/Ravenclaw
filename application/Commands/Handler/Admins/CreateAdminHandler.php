<?php


namespace Application\Commands\Handler\Admins;


use Application\Commands\Command\Admins\CreateAdminCommand;
use Application\Commands\Command\Users\CreateUserCommand;
use Application\Exceptions\SettingRoleUserNotPermittedException;
use Application\Services\Admins\AdminServiceInterface;
use Application\Services\Users\UserServiceInterface;
use Domain\Entities\Admin;
use Infrastructure\CommandBus\Handler\HandlerInterface;

class CreateAdminHandler implements HandlerInterface
{
    private UserServiceInterface $userService;
    private AdminServiceInterface $adminService;

    public function __construct(UserServiceInterface $userService, AdminServiceInterface $adminService)
    {
        $this->userService = $userService;
        $this->adminService = $adminService;
    }

    /**
     * @param CreateAdminCommand $command
     * @throws SettingRoleUserNotPermittedException
     */
    public function handle(CreateAdminCommand $command): void
    {
        $user = $this->userService->createUserByCommand($this->createUserCommand($command));

        $admin = new Admin($command->getRole());
        $this->adminService->persistAndFlush($admin);

        $user->setAdmin($admin);
        $this->userService->persist($user);
    }

    private function createUserCommand(CreateAdminCommand $command): CreateUserCommand
    {
        return new CreateUserCommand($command->getName(), $command->getSurname(), $command->getUsername(), $command->getEmail(), $command->getPassword());
    }
}
