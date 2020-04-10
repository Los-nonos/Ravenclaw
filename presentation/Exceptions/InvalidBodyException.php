<?php

declare(strict_types=1);

namespace Presentation\Exceptions;

use const Presentation\Http\Enums\HTTP_CODES;

class InvalidBodyException extends BasePresentationException
{
    public function __construct(string $responseMessage)
    {
        parent::__construct($responseMessage, HTTP_CODES['UNPROCESSABLE_ENTITY']);
    }
}
