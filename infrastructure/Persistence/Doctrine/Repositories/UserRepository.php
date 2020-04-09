<?php

declare(strict_types=1);

namespace Infrastructure\Persistence\Doctrine\Repositories;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Domain\Entities\User;
use Domain\Interfaces\UserRepositoryInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Exception;

class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * DoctrineUserRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, new ClassMetadata(User::class));
    }

    /**
     * @param User $user
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(User $user): void
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update(): void
    {
        $this->getEntityManager()->flush();
    }

    /**
     * @param int $userId
     * @return object
     * @throws Exception
     */
    public function getById(int $userId): ?User
    {
        $user = $this->find($userId);

        if(!$user){
            throw new EntityNotFoundException('User not found');
        }

        return $user;
    }

    /**
     * @param string $email
     * @return User|null
     * @throws EntityNotFoundException
     */
    public function getByTheEmail(string $email): ?User
    {
        $user = $this->findOneBy(['email' => $email]);

        if(!$user){
            throw new EntityNotFoundException('User not found');
        }

        return $user;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function existWithTheEmail(string $email): bool
    {
        $user = $this->findOneBy(['email' => $email]);

        if(!$user){
            return false;
        }
        return true;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function all(): array
    {
        return $this->findAll();
    }

    /**
     * @param User $user
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(User $user): void
    {
        $this->getEntityManager()->remove($user);
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $username
     * @return User|null
     * @throws ORMException
     */
    public function getByUsername(string $username): ?User
    {
        $user = $this->findOneBy(['username'=> $username]);

        if(!$user)
        {
            throw new EntityNotFoundException("User with username $username not found");
        }
        return $user;
    }
}
