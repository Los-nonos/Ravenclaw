<?php


namespace Application\Queries\Handler\Auth;


use Application\Queries\Results\Auth\RenewTokenResult;
use Application\Services\Token\TokenServiceInterface;
use Application\Services\TokenLogin\GenerateRandomTokenService;
use DateTime;
use Domain\Entities\Token;
use Infrastructure\QueryBus\Handler\HandlerInterface;
use Infrastructure\QueryBus\Query\QueryInterface;
use Infrastructure\QueryBus\Result\ResultInterface;

class RenewTokenHandler implements HandlerInterface
{
    private RenewTokenResult $result;

    private TokenServiceInterface $tokenService;

    private GenerateRandomTokenService $randomTokenService;

    public function __construct(
        RenewTokenResult $result,
        TokenServiceInterface $tokenService,
        GenerateRandomTokenService $randomTokenService
    )
    {
        $this->result = $result;
        $this->tokenService = $tokenService;
        $this->randomTokenService = $randomTokenService;
    }


    public function handle(QueryInterface $query): ResultInterface
    {
        $token = $this->tokenService->findOneByHashOrFail($query->getToken());

        $token->setUpdatedAt(new DateTime());

        $token->setHash($this->randomTokenService->generate(Token::LENGTH));

        $this->tokenService->update();

        $this->result->setToken($token);
        return $this->result;
    }
}
