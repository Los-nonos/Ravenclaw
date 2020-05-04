<?php


namespace Application\Commands\Command\Customers;


use Infrastructure\CommandBus\Command\CommandInterface;

class DestroyCustomerByIdCommand implements CommandInterface
{

    private int $id;

    private int $adminId;

    /**
     * DestroyCustomerByIdCommand constructor.
     * @param int $id
     * @param int $adminId
     */
    public function __construct(int $id, int $adminId)
    {
        $this->id = $id;
        $this->adminId = $adminId;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAdminId(): int
    {
        return $this->adminId;
    }
}
