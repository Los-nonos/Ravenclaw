<?php
declare(strict_types=1);

namespace Infrastructure\CommandBus;

use Infrastructure\CommandBus\Command\CommandInterface;
use Infrastructure\CommandBus\Exception\InvalidHandlerException;
use League\Tactician\Exception\InvalidCommandException;
use League\Tactician\Exception\InvalidMiddlewareException;
use League\Tactician\Middleware;

final class CommandBus implements CommandBusInterface
{
    /**
     * @var callable
     */
    private $middlewareChain;

    /**
     * @param Middleware[] $middleware
     */
    public function __construct(array $middleware)
    {
        $this->middlewareChain = $this->createExecutionChain($middleware);
    }

    /**
     * Execute the given command
     * @param CommandInterface $command
     * @throws InvalidHandlerException
     */
    public function handle(CommandInterface $command): void
    {
        if (!is_object($command)) {
            throw InvalidCommandException::forUnknownValue($command);
        }

        $middlewareChain = $this->middlewareChain;

        $result = $middlewareChain($command);

        if (!empty($result)) {
            throw new InvalidHandlerException('A command execution must not return a result');
        }
    }

    /**
     * @param Middleware[] $middlewareList
     * @return callable
     */
    private function createExecutionChain(array $middlewareList): callable
    {
        $lastCallable = function () {
            // the final callable is a no-op
        };

        while ($middleware = array_pop($middlewareList)) {
            if (! $middleware instanceof Middleware) {
                throw InvalidMiddlewareException::forMiddleware($middleware);
            }

            $lastCallable = function ($command) use ($middleware, $lastCallable) {
                return $middleware->execute($command, $lastCallable);
            };
        }

        return $lastCallable;
    }
}
