<?php


namespace Application\Services\Users;


use Application\Commands\Command\Users\CreateUserCommand;
use Application\Exceptions\EntityNotFoundException;
use Application\Services\HashService\HashServiceInterface;
use Domain\Entities\User;
use Domain\Interfaces\Repositories\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

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
}
