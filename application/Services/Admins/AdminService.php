<?php


namespace Application\Services\Admins;


use Application\Exceptions\EntityNotFoundException;
use Domain\Entities\Admin;
use Domain\Interfaces\Repositories\AdminRepositoryInterface;

class AdminService implements AdminServiceInterface
{
    private AdminRepositoryInterface $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * @param int $id
     * @return Admin
     * @throws EntityNotFoundException
     */
    public function findAdminByIdOrFail(int $id): Admin
    {
        $admin = $this->adminRepository->FindById($id);

        if(!isset($admin))
        {
            throw new EntityNotFoundException("Admin with id: $id does not exist");
        }

        return $admin;
    }
}
