<?php


namespace Infrastructure\Payments\Exceptions;


use Exception;

class GatewayNotFound extends Exception
{
    public function __construct($message = "Gateway not found")
    {
        parent::__construct($message);
    }
}
