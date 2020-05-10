<?php


namespace Infrastructure\CommandBus\Handler\Locator;


use League\Tactician\Exception\MissingHandlerException;
use League\Tactician\Handler\Locator\HandlerLocator;

class InferableLocator implements HandlerLocator
{
    private $handlerInstanceResolver;

    public function __construct(HandlerInstanceResolverInterface $handlerInstanceResolver)
    {
        $this->handlerInstanceResolver = $handlerInstanceResolver;
    }

    /**
     * Retrieves the handler for a specified command
     *
     * @param string $commandName
     *
     * @return object
     *
     * @throws MissingHandlerException
     */
    public function getHandlerForCommand($commandName)
    {
        $handler = preg_replace(
            ['/\bCommand\b/'],
            ['Handler'],
            $commandName
        );

        $handler .= "Handler";

        if (!class_exists($handler)) {
            throw MissingHandlerException::forCommand($commandName);
        }

        $callable = $this->handlerInstanceResolver->getCallable();

        return $callable($handler);
    }
}
