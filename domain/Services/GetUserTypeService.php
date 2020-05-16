<?php


namespace Domain\Services;


use Domain\Entities\User;
use Domain\Interfaces\Services\GetUserTypeServiceInterface;

class GetUserTypeService implements GetUserTypeServiceInterface
{
    const USER_ADMIN = 0;
    const USER_CUSTOMER = 1;

    /**
     * Return the user Type, can be one or more
     * @param User $user
     * @return array
     */
    public function handle(User $user) : array
    {
        $userTypes = [];

        if($user->getAdmin()){
            $user->getAdmin()->getId();
            array_push($userTypes, $user->getAdmin());
        } else {
            array_push($userTypes, null);
        }

        if($user->getCustomer()){
            $user->getCustomer()->getId();
            array_push($userTypes, $user->getCustomer());
        } else {
            array_push($userTypes, null);
        }
        return $userTypes;
    }
}
