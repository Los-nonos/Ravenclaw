<?php


namespace Application\Queries\Handler\Auth;


use Application\Exceptions\PasswordNotMatch;
use Application\Queries\Results\Auth\LoginHandlerResult;
use Application\Services\HashService\HashServiceInterface;
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

    private HashServiceInterface $hashService;

    public function __construct(
        TokenLoginServiceInterface $tokenLoginService,
        UserServiceInterface $userService,
        LoginHandlerResult $loginResult,
        HashServiceInterface $hashService
    )
    {
        $this->tokenLoginService = $tokenLoginService;
        $this->userService = $userService;
        $this->loginResult = $loginResult;
        $this->hashService = $hashService;
    }

    /**
     * @param QueryInterface $query
     * @return ResultInterface
     * @throws PasswordNotMatch
     */
    public function handle(QueryInterface $query): ResultInterface
    {
        $user = $this->userService->findUserByUsernameOrFail($query->getUsername());

        // todo: add validation password, stupid

        if(!$this->hashService->check($query->getPassword(), $user->getPassword()))
        {
            throw new PasswordNotMatch();
        }
        $token = $this->tokenLoginService->createToken($user);

        $this->loginResult->setToken($token);
        return $this->loginResult;
    }
}
