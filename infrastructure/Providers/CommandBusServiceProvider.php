<?php


namespace Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use Infrastructure\CommandBus\CommandBus;
use Infrastructure\CommandBus\CommandBusInterface;
use Infrastructure\CommandBus\Handler\CommandNameExtractor\CommandNameExtractor;
use Infrastructure\CommandBus\Handler\Locator\HandlerInstanceResolver;
use Infrastructure\CommandBus\Handler\Locator\InferableLocator;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\MethodNameInflector\HandleInflector;

class CommandBusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            CommandBusInterface::class,
            static function (Application $application) {
                $handlerMiddleware = new CommandHandlerMiddleware(
                    new CommandNameExtractor(),
                    new InferableLocator(new HandlerInstanceResolver($application)),
                    new HandleInflector()
                );

                return new CommandBus([$handlerMiddleware]);
            }
        );
    }
}
