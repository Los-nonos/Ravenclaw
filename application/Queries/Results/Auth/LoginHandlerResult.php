<?php


namespace Application\Queries\Results\Auth;


use Domain\Entities\Token;
use Infrastructure\QueryBus\Result\ResultInterface;

class LoginHandlerResult implements ResultInterface
{
    private Token $token;

    public function setToken(Token $token)
    {
        $this->token = $token;
    }

    public function getToken() {
        return $this->token;
    }
}
