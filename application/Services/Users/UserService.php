<?php


namespace Application\Services\Users;


use Application\Commands\Command\Users\CreateUserCommand;
use Application\Exceptions\EntityNotFoundException;
use Application\Services\HashService\HashServiceInterface;
use Domain\Entities\User;
use Domain\Interfaces\Repositories\UserRepositoryInterface;

class UserService implements UserServiceInterface
{
    private UserRepositoryInterface $repository;
    private HashServiceInterface $hashService;

    public function __construct(
        UserRepositoryInterface $repository,
        HashServiceInterface $hashService
    )
    {
        $this->repository = $repository;
        $this->hashService = $hashService;
    }


    public function createUserByCommand(CreateUserCommand $command): User
    {
        $user = new User();

        $user->setName($command->getName());
        $user->setSurname($command->getSurname());
        $user->setEmail($command->getEmail());

        $passwordHashed = $this->hashService->make($command->getPassword());

        $user->setPassword($passwordHashed);
        $user->setUsername($command->getUsername());

        return $user;
    }

    public function persist(User $user): void
    {
        $this->repository->save($user);
    }

    /**
     * @param int $id
     * @return User
     * @throws EntityNotFoundException
     */
    public function findUserByIdOrFail(int $id): ?User
    {
        $user =  $this->repository->getById($id);

        if(!$user) {
            throw new EntityNotFoundException("User with id: $id not found");
        }

        return $user;
    }

    /**
     * @param string $username
     * @return User
     * @throws EntityNotFoundException
     */
    public function findUserByUsernameOrFail(string $username): User
    {
        $user = $this->repository->getByUsername($username);

        if(!$user) {
            throw new EntityNotFoundException("User with username: $username not found");
        }

        return $user;
    }

    public function createFromCommand(CreateUserCommand $userCommand)
    {
        // TODO: Implement createFromCommand() method.
    }

    public function findOneByIdOrFail(int $id): User
    {
        // TODO: Implement findOneByIdOrFail() method.
    }

    public function findOneByEmailOrFail(string $email): User
    {
        // TODO: Implement findOneByEmailOrFail() method.
    }

    public function existWithEmail(string $email): bool
    {
        // TODO: Implement existWithEmail() method.
    }

    public function update()
    {
        // TODO: Implement update() method.
    }

    public function findEmployees($page, $size): array
    {
        // TODO: Implement findEmployees() method.
    }

    public function findCustomers($page, $size, $name, $dni, $cuil)
    {
        // TODO: Implement findCustomers() method.
    }
}
