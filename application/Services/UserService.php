<?php


namespace Application\Services;


use Application\Commands\Users\CreateUserCommand;
use Domain\Entities\User;
use Domain\Interfaces\Repositories\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }


    public function CreateUserByCommand(CreateUserCommand $command): User
    {
        $user = new User();

        $user->setName($command->getName());
        $user->setSurname($command->getSurname());
        $user->setEmail($command->getEmail());
        $user->setPassword($command->getPassword());
        $user->setUsername($command->getUsername());

        return $user;
    }

    public function Persist(User $user): void
    {
        $this->repository->save($user);
    }

    public function FindUserById(int $id): ?User
    {
        return $this->repository->getById($id);
    }
}
