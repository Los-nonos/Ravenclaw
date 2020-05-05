<?php


namespace Application\Services\Token;


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
}
