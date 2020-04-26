<?php
declare(strict_types=1);

namespace Infrastructure\QueryBus\Handler\MethodNameInflector;

use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;

/**
 * Handle query by calling the "handle" method.
 */
class HandleInflector implements MethodNameInflector
{
    /**
     * Return the method name to call on the query handler and return it.
     *
     * @param object $query
     * @param object $queryHandler
     *
     * @return string
     */
    public function inflect($query, $queryHandler)
    {
        return 'handle';
    }
}
