<?php


namespace Application\Queries\Query\Customers;


use Infrastructure\QueryBus\Query\QueryInterface;

class ShowCustomerByIdQuery implements QueryInterface
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
