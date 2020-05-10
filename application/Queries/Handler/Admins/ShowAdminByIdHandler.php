<?php


namespace Application\Queries\Handler\Admins;


use Application\Queries\Results\Admins\ShowAdminByIdResult;
use Application\Services\Admins\AdminServiceInterface;
use Application\Services\Users\UserServiceInterface;
use Infrastructure\QueryBus\Handler\HandlerInterface;
use Infrastructure\QueryBus\Query\QueryInterface;
use Infrastructure\QueryBus\Result\ResultInterface;

class ShowAdminByIdHandler implements HandlerInterface
{
    private ShowAdminByIdResult $result;

    private AdminServiceInterface $adminService;

    private UserServiceInterface $userService;

    public function __construct(
        AdminServiceInterface $adminService,
        UserServiceInterface $userService,
        ShowAdminByIdResult $result
    )
    {
        $this->result = $result;
        $this->adminService = $adminService;
        $this->userService = $userService;
    }

    public function handle(QueryInterface $query): ResultInterface
    {
        $admin = $this->adminService->findAdminByIdOrFail($query->getId());

        $this->result->setAdmin($admin);
        return $this->result;
    }
}
