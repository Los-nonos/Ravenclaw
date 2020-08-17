<?php


namespace Application\Exceptions;


use App\Exceptions\ApplicationException;
use Presentation\Http\Enums\HttpCodes;
use Throwable;

class CurrencyNotSupport extends ApplicationException
{

    /**
     * CurrencyNotSupport constructor.
     */
    public function __construct($message = "Currency not support for API")
    {
        parent::__construct($message, HttpCodes::UNPROCESSABLE_ENTITY);
    }
}
