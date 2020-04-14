<?php


namespace Infrastructure\Persistence\Doctrine\Repositories;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\ORMException;
use Domain\Entities\Admin;
use Domain\Interfaces\Repositories\AdminRepositoryInterface;

class AdminRepository extends EntityRepository implements AdminRepositoryInterface
{
    /**
     * DoctrineUserRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, new ClassMetadata(Admin::class));
    }

    /**
     * @param Admin $admin
     * @throws ORMException
     */
    public function Persist(Admin $admin): void
    {
        $this->getEntityManager()->persist($admin);
        $this->getEntityManager()->flush();
    }

    public function Update(): void
    {
        // TODO: Implement Update() method.
    }

    public function FindById($id): Admin
    {
        // TODO: Implement FindById() method.
    }
}
