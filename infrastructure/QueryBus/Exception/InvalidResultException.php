<?php
declare(strict_types=1);

namespace Infrastructure\QueryBus\Exception;

use Exception;
use League\Tactician\Exception\Exception as TacticianException;

final class InvalidResultException extends Exception implements TacticianException
{

}
