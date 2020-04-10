<?php


namespace Application\Results\Customers;


use Domain\Entities\Customer;
use Domain\Entities\User;

class CreateCustomerResult implements CreateCustomerResultInterface
{
    private User $user;

    public function getCustomer(): Customer
    {
        return $this->user->getCustomer();
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
