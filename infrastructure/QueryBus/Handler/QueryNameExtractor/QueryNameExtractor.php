<?php
declare(strict_types=1);

namespace Infrastructure\QueryBus\Handler\QueryNameExtractor;

use League\Tactician\Exception\CanNotDetermineCommandNameException;
use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor as QueryNameExtractorInterface;

/**
 * Extract the name from the query class
 */
class QueryNameExtractor implements QueryNameExtractorInterface
{
    /**
     * Extract the name from a query
     *
     * @param object $query
     *
     * @return string
     *
     * @throws CannotDetermineCommandNameException
     */
    public function extract($query)
    {
        $queryName = get_class($query);

        if (!$queryName) {
            throw CannotDetermineCommandNameException::forCommand($query);
        }

        return $queryName;
    }
}
