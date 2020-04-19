<?php
declare(strict_types=1);

namespace Infrastructure\CommandBus\Exception;

use Exception;
use League\Tactician\Exception\Exception as TacticianException;

class InvalidHandlerException extends Exception implements TacticianException
{

}
