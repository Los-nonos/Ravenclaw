<?php


namespace Application\Queries\Handler\Auth;


use Application\Queries\Results\Auth\LoginHandlerResult;
use Application\Services\TokenLogin\TokenLoginServiceInterface;
use Application\Services\Users\UserServiceInterface;
use Infrastructure\QueryBus\Handler\HandlerInterface;
use Infrastructure\QueryBus\Query\QueryInterface;
use Infrastructure\QueryBus\Result\ResultInterface;

class LoginHandler implements HandlerInterface
{
    private TokenLoginServiceInterface $tokenLoginService;

    private UserServiceInterface $userService;

    private LoginHandlerResult $loginResult;

    public function __construct(
        TokenLoginServiceInterface $tokenLoginService,
        UserServiceInterface $userService,
        LoginHandlerResult $loginResult
    )
    {
        $this->tokenLoginService = $tokenLoginService;
        $this->userService = $userService;
        $this->loginResult = $loginResult;
    }

    public function handle(QueryInterface $query): ResultInterface
    {
        $user = $this->userService->findUserByUsernameOrFail($query->getUsername());

        $token = $this->tokenLoginService->createToken($user);
        // todo: add validation password, stupid

        $this->loginResult->setToken($token);
        return $this->loginResult;
    }
}
