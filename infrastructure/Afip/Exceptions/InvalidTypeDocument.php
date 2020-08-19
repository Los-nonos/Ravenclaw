<?php


namespace Infrastructure\Afip\Exceptions;


use App\Exceptions\ApplicationException;
use Presentation\Http\Enums\HttpCodes;
use Throwable;

class InvalidTypeDocument extends ApplicationException
{
    public function __construct($message = "type document is invalid")
    {
        parent::__construct($message, HttpCodes::UNPROCESSABLE_ENTITY);
    }
}
