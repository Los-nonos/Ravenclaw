<?php


namespace Application\Exceptions;


use App\Exceptions\ApplicationException;
use Presentation\Http\Enums\HttpCodes;
use Throwable;

class PasswordNotMatch extends ApplicationException
{

    /**
     * PasswordNotMatch constructor.
     * @param string $message
     */
    public function __construct($message = "Password don't match")
    {
        parent::__construct($message, HttpCodes::BAD_REQUEST);
    }
}
