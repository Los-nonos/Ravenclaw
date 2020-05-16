<?php


namespace Application\Exceptions;


use App\Exceptions\ApplicationException;
use Presentation\Http\Enums\HttpCodes;
use Throwable;

class FailedPaymentException extends ApplicationException
{
    public function __construct($message = "Payment error in external service")
    {
        parent::__construct($message, HttpCodes::INTERNAL_ERROR);
    }
}
