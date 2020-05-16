<?php


namespace Domain\Interfaces\Services;


use Domain\Entities\User;

interface GetUserTypeServiceInterface
{


    public function handle(User $user): array;
}
