<?php


namespace Application\Results\Customers;


use Domain\Entities\Customer;
use Domain\Entities\User;

class CreateCustomerResult
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getCustomer(): Customer
    {
        return $this->user->getCustomer();
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
