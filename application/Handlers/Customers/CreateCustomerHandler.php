<?php


namespace Application\Handlers\Customers;

use Application\Commands\Customers\CreateCustomerCommand;
use Application\Commands\Users\CreateUserCommand;
use Application\Exceptions\SettingRoleUserNotPermittedException;
use Application\Results\Customers\CreateCustomerResultInterface;
use Application\Services\UserServiceInterface;
use Domain\Entities\Customer;
use Domain\Interfaces\Repositories\CustomerRepositoryInterface;

class CreateCustomerHandler
{
    private UserServiceInterface $userService;
    private CustomerRepositoryInterface $customerRepository;
    private CreateCustomerResultInterface $result;

    public function __construct(UserServiceInterface $userService, CustomerRepositoryInterface $customerRepository, CreateCustomerResultInterface $result)
    {
        $this->userService = $userService;
        $this->customerRepository = $customerRepository;
        $this->result = $result;
    }

    public function handle(CreateCustomerCommand $command): CreateCustomerResultInterface
    {
        $customer = new Customer($command->getDomain(), $command->getOrganizationName());
        $userCommand = $this->createUserCommandFromCustomerCommand($command);
        $user = $this->userService->CreateUserByCommand($userCommand);

        $this->customerRepository->save($customer);

        try {
            $user->setCustomer($customer);
        } catch (SettingRoleUserNotPermittedException $e) {

        }

        $this->userService->Persist($user);
        $this->result->setUser($user);

        return $this->result;
    }

    private function createUserCommandFromCustomerCommand(CreateCustomerCommand $command): CreateUserCommand
    {
        return new CreateUserCommand($command->getName(), $command->getSurname(), $command->getUsername(), $command->getEmail(), $command->getPassword());
    }
}
