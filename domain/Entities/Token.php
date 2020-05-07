<?php


namespace Domain\Entities;


use DateTime;

class Token
{
    const LENGTH = 32;
    const EXPIRATION_TIME = '-30minutes';

    /**
     * @var User
     *
     */
    private User $user;

    /**
     * @var string
     */
    private string $hash;
    /**
     * @var DateTime
     */
    private DateTime $createdAtDate;
    /**
     * @var DateTime
     */
    private DateTime $updatedAtDate;

    public function __construct()
    {

    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User {
        return $this->user;
    }

    public function setHash($handle): string
    {
        return $this->hash;
    }

    public function setCreatedAt(DateTime $param)
    {
        $this->createdAtDate = $param;
    }

    public function getCreatedAt(): DateTime {
        return $this->createdAtDate;
    }

    public function setUpdatedAt(DateTime $param)
    {
        $this->updatedAtDate = $param;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAtDate;
    }

    public function isExpired(): bool
    {
        return ! intval($this->getCreatedAt()->format('U')) > strtotime(Token::EXPIRATION_TIME);
    }
}
