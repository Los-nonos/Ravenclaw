<?php


namespace Infrastructure\Afip\Exceptions;


use App\Exceptions\ApplicationException;
use Presentation\Http\Enums\HttpCodes;

class InvalidAfipConcept extends ApplicationException
{

    /**
     * InvalidAfipConcept constructor.
     */
    public function __construct($message = "Invalid concept, not found")
    {
        parent::__construct($message, HttpCodes::UNPROCESSABLE_ENTITY);
    }
}
