<?php


namespace Application\Exceptions;


use Throwable;

class InvalidServicePaymentException extends \Exception
{
    public function __construct($message = "service not valid", $code = 400, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
