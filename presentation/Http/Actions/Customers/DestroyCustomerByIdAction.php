<?php


namespace Presentation\Http\Actions\Customers;


use Infrastructure\CommandBus\CommandBusInterface;
use Presentation\Http\Adapters\Customers\DestroyCustomerByIdAdapter;

class DestroyCustomerByIdAction
{
    public function __construct(
        DestroyCustomerByIdAdapter $adapter,
        CommandBusInterface $commandBus,
        DestroyCustomerByIdPresenter $presenter
    )
    {

    }

    public function __invoke()
    {

    }
}
