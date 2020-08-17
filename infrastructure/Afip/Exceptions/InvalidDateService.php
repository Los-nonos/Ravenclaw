<?php


namespace Infrastructure\Afip\Exceptions;


use App\Exceptions\ApplicationException;
use Presentation\Http\Enums\HttpCodes;

class InvalidDateService extends ApplicationException
{

    /**
     * InvalidDateService constructor.
     * @param string $message
     */
    public function __construct($message = "Date not set")
    {
        parent::__construct($message, HttpCodes::UNPROCESSABLE_ENTITY);
    }
}
