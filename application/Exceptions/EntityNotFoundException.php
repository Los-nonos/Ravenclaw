<?php


namespace Application\Exceptions;


use App\Exceptions\BasePresentationException;
use Throwable;

class EntityNotFoundException extends BasePresentationException
{
    public function __construct($message = "", Throwable $previous = null)
    {
        parent::__construct($message, 404, $previous);
    }
}
