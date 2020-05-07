<?php


namespace Application\Services\Token;


use Domain\Entities\Token;

interface TokenServiceInterface
{
    public function persist(Token $token): void;

    public function exist(string $token);

    public function findOneByHashOrFail(string $tokenHash): Token;

    public function update();
}
