<?php


namespace Infrastructure\Persistence\Repositories;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Domain\Entities\Token;
use Domain\Interfaces\Repositories\TokenRepositoryInterface;

class TokenRepository extends EntityRepository implements TokenRepositoryInterface
{
    /**
     * DoctrineUserRepository constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager, new ClassMetadata(Token::class));
    }

    /**
     * @param Token $token
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function persist(Token $token): void
    {
        $this->getEntityManager()->persist($token);
        $this->update();
    }

    /**
     * @param string $hash
     * @return bool
     */
    public function exist(string $hash)
    {
        $token = $this->findOneBy(['hash' => $hash]);

        return isset($token);
    }

    /**
     * @param string $tokenHash
     * @return Token|null|object
     */
    public function findOneByHash(string $tokenHash)
    {
        return $this->findOneBy(['hash' => $tokenHash]);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function update()
    {
        $this->getEntityManager()->flush();
    }
}
