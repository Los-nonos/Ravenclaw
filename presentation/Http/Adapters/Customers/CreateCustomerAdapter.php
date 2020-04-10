<?php


namespace Presentation\Http\Adapters\Customers;


use Application\Commands\Customers\CreateCustomerCommand;

class CreateCustomerAdapter
{
    public function from($request): CreateCustomerCommand
    {
        return new CreateCustomerCommand('', '', '','','','');
    }
}
