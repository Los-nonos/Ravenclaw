<?php

declare(strict_types=1);

namespace App\Exceptions;

use  Presentation\Http\Enums\HttpCodes;

class InvalidBodyException extends BasePresentationException
{
    public function __construct(string $responseMessage)
    {
        parent::__construct($responseMessage, HttpCodes::UNPROCESSABLE_ENTITY);
    }
}
