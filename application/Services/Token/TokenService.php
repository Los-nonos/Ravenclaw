<?php


namespace Application\Services\Token;


use Application\Exceptions\EntityNotFoundException;
use Domain\Entities\Token;
use Domain\Interfaces\Repositories\TokenRepositoryInterface;

class TokenService implements TokenServiceInterface
{
    private TokenRepositoryInterface $tokenRepository;

    public function __construct(
        TokenRepositoryInterface $tokenRepository
    )
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function persist(Token $token): void {
        $this->tokenRepository->persist($token);
    }

    public function exist(string $token)
    {
        return $this->tokenRepository->exist($token);
    }

    /**
     * @param string $tokenHash
     * @return mixed
     * @throws EntityNotFoundException
     */
    public function findOneByHashOrFail(string $tokenHash): Token
    {
        $token = $this->tokenRepository->findOneByHash($tokenHash);

        if(!$token) {
            throw new EntityNotFoundException("Token hash not found");
        }

        return $token;
    }

    public function update()
    {
        $this->tokenRepository->update();
    }
}
