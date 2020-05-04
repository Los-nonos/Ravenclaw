<?php


namespace Infrastructure\CommandBus;


use Infrastructure\CommandBus\Command\CommandInterface;

interface CommandBusInterface
{
    public function handle(CommandInterface $command): void;
}
