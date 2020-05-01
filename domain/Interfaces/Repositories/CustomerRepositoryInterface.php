<?php


namespace Domain\Interfaces\Repositories;


use Domain\Entities\Customer;
use Exception;

interface CustomerRepositoryInterface
{
    /**
     * @param Customer $customer
     * @throws Exception
     */
    public function save(Customer $customer): void;
    public function getById($id): Customer;
    public function indexPaginated($page, $size, array $values): array;

    /**
     * @param Customer $customer
     * @throws Exception
     */
    public function destroy(Customer $customer): void;
}
