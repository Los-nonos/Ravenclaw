<?php


namespace Application\Handlers\Customers;

use Application\Commands\Customers\CreateCustomerCommand;
use Application\Commands\Users\CreateUserCommand;
use Application\Exceptions\SettingRoleUserNotPermittedException;
use Application\Results\Customers\CreateCustomerResultInterface;
use Application\Services\Notifiable\NotifiableService;
use Application\Services\Users\UserServiceInterface;
use Domain\Entities\Customer;
use Domain\Interfaces\Repositories\CustomerRepositoryInterface;

class CreateCustomerHandler
{
    private UserServiceInterface $userService;
    private CustomerRepositoryInterface $customerRepository;
    private CreateCustomerResultInterface $result;
    private NotifiableService $notifiableService;

    public function __construct(
        UserServiceInterface $userService,
        CustomerRepositoryInterface $customerRepository,
        NotifiableService $notifiableService,
        CreateCustomerResultInterface $result)
    {
        $this->userService = $userService;
        $this->customerRepository = $customerRepository;
        $this->notifiableService = $notifiableService;
        $this->result = $result;
    }

    /**
     * @param CreateCustomerCommand $command
     * @return CreateCustomerResultInterface
     * @throws SettingRoleUserNotPermittedException
     */
    public function handle(CreateCustomerCommand $command): CreateCustomerResultInterface
    {
        $customer = new Customer($command->getDomain(), $command->getOrganizationName());
        $userCommand = $this->createUserCommandFromCustomerCommand($command);
        $user = $this->userService->CreateUserByCommand($userCommand);

        $this->customerRepository->save($customer);


        $user->setCustomer($customer);

        $this->userService->Persist($user);
        $this->result->setUser($user);

        $data = $this->notifiableService->GetNotifiableData();

        $data->setSubject('Welcome to Zeep service');

        $this->notifiableService->SendEmail($data);

        return $this->result;
    }

    private function createUserCommandFromCustomerCommand(CreateCustomerCommand $command): CreateUserCommand
    {
        return new CreateUserCommand($command->getName(), $command->getSurname(), $command->getUsername(), $command->getEmail(), $command->getPassword());
    }
}
