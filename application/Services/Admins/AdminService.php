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
        return $this->adminRepository->findById($id);
    }

    public function persistAndFlush(Admin $admin): void
    {
        $this->adminRepository->persist($admin);
        $this->adminRepository->update();
    }
}
