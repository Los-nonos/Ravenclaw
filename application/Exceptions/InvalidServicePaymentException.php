<?php


namespace Application\Exceptions;


use Presentation\Http\Enums\HttpCodes;
use Throwable;

class InvalidServicePaymentException extends \Exception
{
    public function __construct($message = "service not valid", $code = HttpCodes::BAD_REQUEST, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
