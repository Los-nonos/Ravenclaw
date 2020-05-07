<?php


namespace Domain\Interfaces\Repositories;


use Domain\Entities\Token;

interface TokenRepositoryInterface
{
    public function persist(Token $token): void;

    public function findByToken(string $token);

    public function exist(string $token);
}
