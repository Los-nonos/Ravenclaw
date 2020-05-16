<?php


namespace Application\Services\TokenLogin;


use Application\Services\Token\TokenServiceInterface;
use Domain\Entities\Token;
use Domain\Entities\User;
use Domain\Interfaces\Repositories\TokenRepositoryInterface;

class TokenLoginService implements TokenLoginServiceInterface
{
    private GenerateRandomTokenService $createRandomTokenService;
    private TokenRepositoryInterface $tokenRepository;

    public function __construct(
        GenerateRandomTokenService $createRandomTokenService,
        TokenRepositoryInterface $tokenRepository
    )
    {
        $this->createRandomTokenService = $createRandomTokenService;
        $this->tokenRepository = $tokenRepository;
    }

    public function createToken(User $user): Token
    {
        $token = new Token();

        $token->setUser($user);

        $token->setHash($this->createRandomTokenService->generate(Token::LENGTH));

        $token->setCreatedAt(new \DateTime("now"));

        $token->setUpdatedAt(new \DateTime("now"));

        $this->tokenRepository->persist($token);

        return $token;
    }

    public function findByHash(?string $hash): ?Token
    {
        return $this->tokenRepository->findOneByHash($hash);
    }

    public function exist(string $hash): bool
    {
        return $this->tokenRepository->exist($hash);
    }
}
