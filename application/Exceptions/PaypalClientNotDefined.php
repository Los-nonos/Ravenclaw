<?php


namespace Application\Exceptions;


use App\Exceptions\ApplicationException;

class PaypalClientNotDefined extends ApplicationException
{
    /**
     * PaypalClientNotDefined constructor.
     * @param string $message
     */
    public function __construct(string $message = "Client id not defined")
    {
        parent::__construct($message, 400);
    }
}
