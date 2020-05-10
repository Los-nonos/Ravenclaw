<?php


namespace Presentation\Http\Adapters\Auth;


use App\Exceptions\InvalidBodyException;
use Application\Queries\Query\Auth\LoginQuery;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Schemas\Auth\LoginSchema;
use Presentation\Http\Validators\Utils\ValidatorServiceInterface;

class LoginAdapter
{
    private ValidatorServiceInterface $validatorService;

    private LoginSchema $loginSchema;

    public function __construct(
        ValidatorServiceInterface $validatorService,
        LoginSchema $loginSchema
    )
    {
        $this->validatorService = $validatorService;
        $this->loginSchema = $loginSchema;
    }

    /**
     * @param Request $request
     * @return LoginQuery
     * @throws InvalidBodyException
     */
    public function from(Request $request)
    {
        $this->validatorService->make($request->all(), $this->loginSchema->getRules());

        if($this->validatorService->isFail()) {
            throw new InvalidBodyException($this->validatorService->getErrors());
        }

        return new LoginQuery(
            $request->input('username'),
            $request->input('password')
        );
    }
}
