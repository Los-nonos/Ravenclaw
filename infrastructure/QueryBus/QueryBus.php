<?php
declare(strict_types=1);

namespace Infrastructure\QueryBus;

use Infrastructure\QueryBus\Exception\InvalidHandlerException;
use Infrastructure\QueryBus\Exception\InvalidResultException;
use Infrastructure\QueryBus\Query\QueryInterface;
use Infrastructure\QueryBus\Result\ResultInterface;
use League\Tactician\Exception\InvalidMiddlewareException;
use League\Tactician\Middleware;

final class QueryBus implements QueryBusInterface
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
     * Execute the given query and return a result
     * @param QueryInterface $query
     * @return ResultInterface
     * @throws InvalidHandlerException
     * @throws InvalidResultException
     */
    public function handle(QueryInterface $query): ResultInterface
    {
        $middlewareChain = $this->middlewareChain;

        $result = $middlewareChain($query);

        if (empty($result)) {
            throw new InvalidHandlerException('A query execution must return a result');
        }

        if (! $result instanceof ResultInterface) {
            throw new InvalidResultException('The result must be an instance of ResultInterface');
        }

        return $result;
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

            $lastCallable = function ($query) use ($middleware, $lastCallable) {
                return $middleware->execute($query, $lastCallable);
            };
        }

        return $lastCallable;
    }
}
