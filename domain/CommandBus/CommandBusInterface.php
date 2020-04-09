<?php


namespace Domain\CommandBus;


interface CommandBusInterface
{
    public function handle($command);
}
