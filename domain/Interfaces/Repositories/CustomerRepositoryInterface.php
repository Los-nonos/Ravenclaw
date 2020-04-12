<?php


namespace Domain\Interfaces\Repositories;


use Domain\Entities\Customer;

interface CustomerRepositoryInterface
{
    public function save(Customer $customer): void;
    public function update(): void;
    public function getById($id): Customer;
    public function indexPaginated($page, $size, array $values): array;
}
