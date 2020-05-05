<?php


namespace Application\Services\TokenLogin;


use Application\Services\Token\TokenServiceInterface;
use Domain\Entities\Token;
use Domain\Entities\User;

class TokenLoginService implements TokenLoginServiceInterface
{
    private GenerateRandomTokenService $createRandomTokenService;
    private TokenServiceInterface $tokenRepository;

    public function __construct(
        GenerateRandomTokenService $createRandomTokenService,
        TokenServiceInterface $tokenRepository
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

        $token->setCreatedAt(new \DateTime());

        $token->setUpdatedAt(new \DateTime());

        $this->tokenRepository->persist($token);

        return $token;
    }
}
