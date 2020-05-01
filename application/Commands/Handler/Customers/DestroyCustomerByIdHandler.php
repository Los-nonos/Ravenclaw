<?php


namespace Application\Commands\Handler\Customers;


use Application\Exceptions\InvalidRoleException;
use Application\Services\Admins\AdminServiceInterface;
use Application\Services\Customer\CustomerServiceInterface;
use Infrastructure\CommandBus\Handler\HandlerInterface;

class DestroyCustomerByIdHandler implements HandlerInterface
{
    private CustomerServiceInterface $customerService;

    private AdminServiceInterface $adminService;

    public function __construct(
        CustomerServiceInterface $customerService,
        AdminServiceInterface $adminService
    )
    {
        $this->customerService = $customerService;
        $this->adminService = $adminService;
    }

    /**
     * @param $command
     * @throws InvalidRoleException
     */
    public function handle($command): void {
        $admin = $this->adminService->findAdminByIdOrFail($command->getAdminId());

        if($admin->isMaintainer()) {
            $this->customerService->destroyOrFail($command->getId());
        }
        else {
            throw new InvalidRoleException(`You hasn't a maintainer role`);
        }
    }
}
