<?php


namespace Application\Commands\Handler\Customers;

use Application\Commands\Command\Customers\CreateCustomerCommand;
use Application\Commands\Command\Users\CreateUserCommand;
use Application\Exceptions\SettingRoleUserNotPermittedException;
use Application\Services\Notifiable\NotifiableServiceInterface;
use Application\Services\Users\UserServiceInterface;
use Domain\Entities\Customer;
use Domain\Interfaces\Repositories\CustomerRepositoryInterface;
use Exception;
use Infrastructure\CommandBus\Handler\HandlerInterface;

class CreateCustomerHandler implements HandlerInterface
{
    private UserServiceInterface $userService;
    private CustomerRepositoryInterface $customerRepository;
    private NotifiableServiceInterface $notifiableService;

    public function __construct(
        UserServiceInterface $userService,
        CustomerRepositoryInterface $customerRepository,
        NotifiableServiceInterface $notifiableService)
    {
        $this->userService = $userService;
        $this->customerRepository = $customerRepository;
        $this->notifiableService = $notifiableService;
    }

    /**
     * @param CreateCustomerCommand $command
     * @throws SettingRoleUserNotPermittedException
     * @throws Exception
     */
    public function handle(CreateCustomerCommand $command): void
    {
        $customer = new Customer($command->getDomain(), $command->getOrganizationName());
        $userCommand = $this->createUserCommandFromCustomerCommand($command);
        $user = $this->userService->createUserByCommand($userCommand);

        $this->customerRepository->save($customer);


        $user->setCustomer($customer);

        $this->userService->persist($user);

        $data = $this->notifiableService->GetNotifiableData();

        $data->setSubject('Welcome to Zeep service');

        $this->notifiableService->SendEmail($data);
    }

    private function createUserCommandFromCustomerCommand(CreateCustomerCommand $command): CreateUserCommand
    {
        return new CreateUserCommand($command->getName(), $command->getSurname(), $command->getUsername(), $command->getEmail(), $command->getPassword());
    }
}
