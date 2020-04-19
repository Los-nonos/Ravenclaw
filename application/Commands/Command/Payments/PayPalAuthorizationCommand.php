<?php


namespace Application\Commands\Command\Payments;


use Domain\CommandBus\CommandInterface;

class PayPalAuthorizationCommand implements CommandInterface
{
    private int $customerId;
    private int $amount;

    public function __construct(int $customerId, int $amount)
    {
        $this->customerId = $customerId;
        $this->amount = $amount;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
