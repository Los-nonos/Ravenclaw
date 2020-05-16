<?php


namespace Domain\Entities;


use DateTime;
use Doctrine\ORM\Mapping as ORM;


class Order
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var bool
     */
    private $charged;

    /**
     * @var Customer
     */
    private $customerId;

    public function __construct(float $amount, DateTime $date, bool $charged)
    {
        $this->amount = $amount;
        $this->charged = $charged;
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

    /**
     * @return bool
     */
    public function isCharged(): bool
    {
        return $this->charged;
    }

    /**
     * @param bool $charged
     */
    public function setCharged(bool $charged): void
    {
        $this->charged = $charged;
    }

    /**
     * @return Customer
     */
    public function getCustomerId(): Customer
    {
        return $this->customerId;
    }

    /**
     * @param Customer $customer
     */
    public function setCustomer(Customer $customer)
    {
        $this->customerId = $customer;
    }
}
