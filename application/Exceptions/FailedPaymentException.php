<?php


namespace Application\Exceptions;


use Presentation\Http\Enums\HttpCodes;
use Throwable;

class FailedPaymentException extends \Exception
{
    public function __construct($message = "")
    {
        parent::__construct($message, HttpCodes::INTERNAL_ERROR);
    }
}
