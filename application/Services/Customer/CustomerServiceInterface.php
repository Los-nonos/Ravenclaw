<?php


namespace Application\Services\Customer;


interface CustomerServiceInterface
{
    public function indexCustomers($command): array;
}
