<?php


namespace Application\Services\Customers;

use Application\Commands\Customers\IndexCustomerCommand;
use Application\Results\Customers\IndexCustomerResultInterface;
use Domain\Entities\Customer;
use Domain\Interfaces\Repositories\CustomerRepositoryInterface;

class CustomerService implements CustomerServiceInterface
{
    private CustomerRepositoryInterface $repository;
    private IndexCustomerResultInterface $result;

    public function __construct(CustomerRepositoryInterface $repository, IndexCustomerResultInterface $result)
    {
        $this->repository = $repository;
        $this->result = $result;
    }

    public function indexCustomers(IndexCustomerCommand $command): IndexCustomerResultInterface
    {
        $page = $command->getPage();

        if(!$page)
        {
            $page = 1;
        }

        $size = $command->getSize();

        if(!$size)
        {
            $size = env('PAGINATED', 10);
        }

        $values = [];

        if($command->getName()){
            $values['name'] = $command->getName();
        }

        if($command->getSurname()){
            $values['surname'] = $command->getSurname();
        }

        if($command->getUsername()){
            $values['username'] = $command->getUsername();
        }

        if($command->getEmail()){
            $values['email'] = $command->getEmail();
        }

        if($command->getDomain()){
            $values['domain'] = $command->getDomain();
        }

        if($command->getOrganizationName()){
            $values['organization_name'] = $command->getOrganizationName();
        }

        $customers = $this->repository->indexPaginated($page, $size, $values);

        $this->result->setCustomers($customers);

        return $this->result;
    }

    public function findCustomerById($id): Customer
    {
        // TODO: Implement findCustomerById() method.
    }
}
