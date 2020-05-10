<?php


namespace Application\Exceptions;


use App\Exceptions\BasePresentationException;
use Throwable;

class EntityNotFoundException extends BasePresentationException
{
    public function __construct($message = "", Throwable $previous = null)
    {
        $message = ['message' => $message];
        parent::__construct(json_encode($message), 404, $previous);
    }
}
