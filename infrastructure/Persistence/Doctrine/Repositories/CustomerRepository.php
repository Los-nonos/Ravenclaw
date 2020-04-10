<?php


namespace Infrastructure\Persistence\Doctrine\Repositories;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Domain\Entities\Customer;
use Domain\Interfaces\Repositories\CustomerRepositoryInterface;

class CustomerRepository extends EntityRepository implements CustomerRepositoryInterface
{

    /**
     * DoctrineUserRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, new ClassMetadata(Customer::class));
    }

    /**
     * @param Customer $customer
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Customer $customer): void
    {
        $this->getEntityManager()->persist($customer);
        $this->getEntityManager()->flush();
    }

    public function update(): void
    {
        // TODO: Implement update() method.
    }

    public function getById(): Customer
    {
        // TODO: Implement getById() method.
    }
}
