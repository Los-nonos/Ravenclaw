<?php


namespace Application\Exceptions;


use Throwable;

class SettingRoleUserNotPermittedException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, 400, $previous);
    }
}
