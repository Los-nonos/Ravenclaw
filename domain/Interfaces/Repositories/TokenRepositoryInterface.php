<?php


namespace Domain\Interfaces\Repositories;


use Domain\Entities\Token;

interface TokenRepositoryInterface
{
    public function persist(Token $token): void;

    public function exist(string $token);

    public function findOneByHash(string $tokenHash);

    public function update();
}
