<?php
declare(strict_types=1);

namespace Infrastructure\Cache\Exception;

final class InvalidArgumentException extends \InvalidArgumentException implements \Psr\Cache\InvalidArgumentException
{

}
