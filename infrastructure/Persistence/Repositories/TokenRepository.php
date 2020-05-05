<?php


namespace Infrastructure\Persistence\Repositories;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
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

    public function persist(Token $token): void
    {

    }
}
