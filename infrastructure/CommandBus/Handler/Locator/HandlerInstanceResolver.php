<?php


namespace Infrastructure\CommandBus\Handler\Locator;

use Illuminate\Foundation\Application;

class HandlerInstanceResolver implements HandlerInstanceResolverInterface
{
    private $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function getCallable(): callable
    {
        $callable = function (string $handlerClassName) {
            return $this->application->make($handlerClassName);
        };

        return $callable;
    }
}
