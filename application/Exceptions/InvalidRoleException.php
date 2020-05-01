<?php


namespace Application\Exceptions;


use Presentation\Http\Enums\HttpCodes;

class InvalidRoleException extends \Exception
{
    /**
     * InvalidRoleException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message, HttpCodes::FORBIDDEN, null);
    }
}
