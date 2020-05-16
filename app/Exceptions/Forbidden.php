<?php


namespace App\Exceptions;


use Presentation\Http\Enums\HttpCodes;
use Throwable;

class Forbidden extends BasePresentationException
{

    /**
     * Forbidden constructor.
     * @param string $message
     */
    public function __construct($message = "Forbidden")
    {
        $message = ['message' => $message];

        parent::__construct(json_encode($message), HttpCodes::FORBIDDEN);
    }
}
