<?php


namespace Application\Handlers\Customers;

use Application\Commands\Customers\CreateCustomerCommand;
use Application\Commands\Users\CreateUserCommand;
use Application\Exceptions\SettingRoleUserNotPermittedException;
use Application\Results\Customers\CreateCustomerResult;
use Application\Services\UserServiceInterface;
use Domain\Entities\Customer;
use Domain\Interfaces\Repositories\CustomerRepositoryInterface;

class CreateCustomerHandler
{
    private UserServiceInterface $userService;
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(UserServiceInterface $userService, CustomerRepositoryInterface $customerRepository)
    {
        $this->userService = $userService;
        $this->customerRepository = $customerRepository;
    }

    public function handle(CreateCustomerCommand $command): CreateCustomerResult
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
        return new CreateCustomerResult($user);
    }

    private function createUserCommandFromCustomerCommand(CreateCustomerCommand $command): CreateUserCommand
    {
        return new CreateUserCommand($command->getName(), $command->getSurname(), $command->getEmail(), $command->getPassword());
    }
}
