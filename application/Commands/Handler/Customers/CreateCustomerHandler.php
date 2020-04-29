<?php


namespace Application\Commands\Handler\Customers;

use Application\Commands\Command\Customers\CreateCustomerCommand;
use Application\Commands\Command\Users\CreateUserCommand;
use Application\Commands\Results\Customers\CreateCustomerResult;
use Application\Exceptions\SettingRoleUserNotPermittedException;
use Application\Services\Notifiable\NotifiableService;
use Application\Services\Users\UserServiceInterface;
use Domain\Entities\Customer;
use Domain\Interfaces\Repositories\CustomerRepositoryInterface;
use Infrastructure\CommandBus\Handler\HandlerInterface;

class CreateCustomerHandler implements HandlerInterface
{
    private UserServiceInterface $userService;
    private CustomerRepositoryInterface $customerRepository;
    private CreateCustomerResult $result;
    private NotifiableService $notifiableService;

    public function __construct(
        UserServiceInterface $userService,
        CustomerRepositoryInterface $customerRepository,
        NotifiableService $notifiableService,
        CreateCustomerResult $result)
    {
        $this->userService = $userService;
        $this->customerRepository = $customerRepository;
        $this->notifiableService = $notifiableService;
        $this->result = $result;
    }

    /**
     * @param CreateCustomerCommand $command
     * @throws SettingRoleUserNotPermittedException
     */
    public function handle(CreateCustomerCommand $command): void
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

        //return $this->result;
    }

    private function createUserCommandFromCustomerCommand(CreateCustomerCommand $command): CreateUserCommand
    {
        return new CreateUserCommand($command->getName(), $command->getSurname(), $command->getUsername(), $command->getEmail(), $command->getPassword());
    }
}
