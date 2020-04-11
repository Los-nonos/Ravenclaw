<?php


namespace Presentation\Interfaces\Customers;


use Application\Results\Customers\IndexCustomerResultInterface;

interface IndexCustomerPresenterInterface
{
    public function fromResult(IndexCustomerResultInterface $result): IndexCustomerPresenterInterface;

    public function getData(): array;
}
