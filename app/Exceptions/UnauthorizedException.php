<?php


namespace App\Exceptions;


use Presentation\Http\Enums\HttpCodes;
use Throwable;

class UnauthorizedException extends BasePresentationException
{

    /**
     * UnauthorizedException constructor.
     * @param string $message
     */
    public function __construct($message = "Unauthorized")
    {
        parent::__construct($message, HttpCodes::UNAUTHORIZED);
    }
}
