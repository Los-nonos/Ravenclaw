<?php


namespace Application\Queries\Query\Admins;


use Infrastructure\QueryBus\Query\QueryInterface;

class ShowAdminByIdQuery implements QueryInterface
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
