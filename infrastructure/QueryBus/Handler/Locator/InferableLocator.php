<?php
declare(strict_types=1);

namespace Infrastructure\QueryBus\Handler\Locator;

use League\Tactician\Exception\MissingHandlerException;
use League\Tactician\Handler\Locator\HandlerLocator;

class InferableLocator implements HandlerLocator
{
    private HandlerInstanceResolverInterface $handlerInstanceResolver;

    public function __construct(HandlerInstanceResolverInterface $handlerInstanceResolver)
    {
        $this->handlerInstanceResolver = $handlerInstanceResolver;
    }

    /**
     * Retrieves the handler for a specified query
     *
     * @param string $queryName
     *
     * @return object
     *
     * @throws MissingHandlerException
     */
    public function getHandlerForCommand($queryName)
    {
        $handler = preg_replace(
            ['/Query/'],
            ['Handler'],
            $queryName
        );

        if (!class_exists($handler)) {
            throw MissingHandlerException::forCommand($queryName);
        }

        $callable = $this->handlerInstanceResolver->getCallable();

        return $callable($handler);
    }
}
