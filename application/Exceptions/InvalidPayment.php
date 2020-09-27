<?php


namespace Application\Exceptions;


use App\Exceptions\ApplicationException;
use Presentation\Http\Enums\HttpCodes;
use Throwable;

class InvalidPayment extends ApplicationException
{

    public function __construct($message = "Invalid payment")
    {
        parent::__construct($message, HttpCodes::UNPROCESSABLE_ENTITY);
    }
}
