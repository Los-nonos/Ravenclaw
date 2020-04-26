<?php


namespace Application\Commands\Results\Customers;


use Domain\Entities\Customer;
use Domain\Entities\User;

interface CreateCustomerResultInterface
{
    public function setUser(User $user): void;
    public function getUser(): User;
    public function getCustomer(): Customer;
}
