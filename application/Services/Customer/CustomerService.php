<?php


namespace Application\Services\Customer;

use Application\Exceptions\EntityNotFoundException;
use Application\Queries\Query\Customers\IndexCustomerQuery;
use Application\Queries\Results\Customers\IndexCustomerResult;
use Domain\Entities\Customer;
use Domain\Interfaces\Repositories\CustomerRepositoryInterface;

class CustomerService implements CustomerServiceInterface
{
    private CustomerRepositoryInterface $repository;
    private IndexCustomerResult $result;

    public function __construct(CustomerRepositoryInterface $repository, IndexCustomerResult $result)
    {
        $this->repository = $repository;
        $this->result = $result;
    }

    public function indexCustomers(IndexCustomerQuery $command): IndexCustomerResult
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

    /**
     * @param $id
     * @return Customer
     * @throws EntityNotFoundException
     */
    public function findCustomerByIdOrFail($id): Customer
    {
        $customer = $this->repository->getById($id);

        if(!isset($customer))
        {
            throw new EntityNotFoundException("Customer with id: $id not found");
        }

        return $customer;
    }
}
