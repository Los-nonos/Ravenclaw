<?php


namespace Presentation\Http\Presenters\Auth;


use Domain\Interfaces\Services\GetUserTypeServiceInterface;
use Firebase\JWT\JWT;
use Infrastructure\QueryBus\Result\ResultInterface;

class LoginPresenter
{
    private GetUserTypeServiceInterface $getUserTypeService;

    public function __construct(GetUserTypeServiceInterface $getUserTypeService)
    {
        $this->getUserTypeService = $getUserTypeService;
    }

    private ResultInterface $result;

    public function fromResult(ResultInterface $result): LoginPresenter {
        $this->result = $result;
        return $this;
    }

    public function getData(): array {
        $user = $this->result->getToken()->getUser();

        $userTypes = $this->getUserTypeService->handle($user);

        $userRoles = [];

        if($userTypes[$this->getUserTypeService::USER_ADMIN] != null){
            array_push($userRoles, 'CompanyAdmin');
        }

        if($userTypes[$this->getUserTypeService::USER_CUSTOMER] != null){
            array_push($userRoles, 'Teacher');
        }

        return [
            'user' => [
                'id' => $user->getId(),
                'firstName' => $user->getName(),
                'lastName' => $user->getSurname(),
                'username' => $user->getUsername(),
                'email' => $user->getEmail(),
                'roles' => $userRoles
            ],
        ];
    }

    public function toJWT()
    {
        $key = "key";//todo: definir key
        $payload = $this->getData();
        return JWT::encode($payload, $key);
    }
}
