<?php


namespace Presentation\Interfaces\Customers;


use Application\Results\Customers\CreateCustomerResultInterface;
use Presentation\Http\Presenters\Customers\CreateCustomerPresenter;

interface CreateCustomerPresenterInterface
{
    public function fromResult(CreateCustomerResultInterface $result): CreateCustomerPresenter;
    public function getData(): array;
}
