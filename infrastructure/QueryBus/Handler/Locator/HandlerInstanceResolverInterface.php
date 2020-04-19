<?php
declare(strict_types=1);

namespace Infrastructure\QueryBus\Handler\Locator;

interface HandlerInstanceResolverInterface
{
    public function getCallable(): callable;
}
