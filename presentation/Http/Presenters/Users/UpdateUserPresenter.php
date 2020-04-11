<?php


namespace Presentation\Http\Presenters\Users;


use Application\Results\Users\UpdateUserResultInterface;
use Presentation\Interfaces\Users\UpdateUserPresenterInterface;

class UpdateUserPresenter implements UpdateUserPresenterInterface
{
    private UpdateUserResultInterface $result;

    public function fromResult(UpdateUserResultInterface $result): UpdateUserPresenter
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
            'message' => 'User has been updated successfully'
        ];
    }
}
