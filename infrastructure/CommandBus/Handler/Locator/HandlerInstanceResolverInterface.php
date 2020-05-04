<?php


namespace Infrastructure\CommandBus\Handler\Locator;


interface HandlerInstanceResolverInterface
{
    public function getCallable(): callable;
}
