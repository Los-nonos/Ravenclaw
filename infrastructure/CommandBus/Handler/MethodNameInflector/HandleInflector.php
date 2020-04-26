<?php

namespace Infrastructure\CommandBus\Handler\MethodNameInflector;

use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;

/**
 * Handle command by calling the "handle" method.
 */
class HandleInflector implements MethodNameInflector
{
    /**
     * Return the method name to call on the command handler and return it.
     *
     * @param object $command
     * @param object $commandHandler
     *
     * @return string
     */
    public function inflect($command, $commandHandler)
    {
        return 'handle';
    }
}
