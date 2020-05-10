<?php


namespace Infrastructure\Persistence\Repositories;


use Application\Exceptions\EntityNotFoundException;
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
    public function persist(Admin $admin): void
    {
        $this->getEntityManager()->persist($admin);
        $this->getEntityManager()->flush();
    }

    public function update(): void
    {
        // TODO: Implement Update() method.
    }

    /**
     * @param $id
     * @return Admin
     * @throws EntityNotFoundException
     */
    public function findById($id): object
    {
        $admin = $this->findOneBy(['id' => $id]);

        if(!isset($admin) || !($admin instanceof Admin))
        {
            throw new EntityNotFoundException("Admin with id: $id does not exist");
        }

        return $admin;
    }
}
