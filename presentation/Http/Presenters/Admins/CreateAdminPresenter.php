<?php


namespace Presentation\Http\Presenters\Admins;


use Application\Commands\Results\Admins\CreateAdminResultInterface;

class CreateAdminPresenter
{
    private CreateAdminResultInterface $result;

    public function fromResult(CreateAdminResultInterface $result): CreateAdminPresenter
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
                'role' => $user->getAdmin()->getRole(),
            ],
            'message' => 'Admin has been created successfully'
        ];
    }
}
