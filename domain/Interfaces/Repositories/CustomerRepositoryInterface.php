<?php


namespace Domain\Interfaces\Repositories;


use Domain\Entities\Customer;

interface CustomerRepositoryInterface
{
    public function save(Customer $customer): void;
    public function update(): void;
    public function getById(): Customer;
}
