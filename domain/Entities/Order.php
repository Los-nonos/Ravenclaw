<?php


namespace Domain\Entities;


use DateTime;
use Doctrine\ORM\Mapping as ORM;


class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @var float
     * @ORM\Column(name="amount")
     */
    private float $amount;

    /**
     * @var DateTime
     * @ORM\Column(name="createdAt")
     */
    private DateTime $date;

    /**
     * @var bool
     * @ORM\Column(name="charged")
     */
    private bool $charged;

    /**
     * @var int
     * @ORM\Column(name="customer_id")
     */
    private int $customerId;

    public function __construct(float $amount, DateTime $date, bool $charged, int $customerId)
    {
        $this->amount = $amount;
        $this->charged = $charged;
        $this->date = $date;
        $this->customerId = $customerId;
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
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }
}
