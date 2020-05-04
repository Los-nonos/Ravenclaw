<?php


namespace Presentation\Http\Presenters\Customers;


use Application\Commands\Results\Customers\CreateCustomerResultInterface;

class CreateCustomerPresenter
{
    private CreateCustomerResultInterface $result;

    public function fromResult(CreateCustomerResultInterface $result): CreateCustomerPresenter
    {
        $this->result = $result;
        return $this;
    }

    public function getData(): array
    {
        $user = $this->result->getUser();

        return [
            'user' => [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'name' => $user->getname(),
                'surname' => $user->getSurname(),
                'email' => $user->getEmail(),
                'domain' => $user->getCustomer()->getDomain(),
                'organization_name' => $user->getCustomer()->getOrganizationName(),
            ],
            'message' => 'Customer has been created successfully'
        ];
    }
}
