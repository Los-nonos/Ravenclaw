<?php

declare(strict_types=1);

namespace App\Exceptions;

use  Presentation\Http\Enums\HttpCodes;

class InvalidBodyException extends BasePresentationException
{
    private array $messages;

    /**
     * InvalidBodyException constructor.
     * @param $responseMessage
     */
    public function __construct($responseMessage = ""|[])
    {
        if(is_array($responseMessage))
        {
            $this->messages = $responseMessage;
            $responseMessage = implode($responseMessage);
        }
        parent::__construct($responseMessage, HttpCodes::UNPROCESSABLE_ENTITY);
    }

    public function getMessages(): array
    {
        return $this->messages;
    }
}
