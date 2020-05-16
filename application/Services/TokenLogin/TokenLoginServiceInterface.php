<?php


namespace Application\Services\TokenLogin;


use Domain\Entities\Token;
use Domain\Entities\User;

interface TokenLoginServiceInterface
{
    public function createToken(User $user): Token;

    public function findByHash(string $hash): ?Token;

    public function exist(string $hash): bool;
}
