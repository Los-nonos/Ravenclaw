<?php


namespace Presentation\Http\Adapters\Auth;


use App\Exceptions\InvalidBodyException;
use Application\Queries\Query\RenewTokenQuery;
use Application\Services\Token\TokenServiceInterface;
use Domain\Interfaces\Repositories\TokenRepositoryInterface;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Schemas\RenewTokenSchema;
use Presentation\Http\Validators\Utils\ValidatorServiceInterface;

class RenewTokenAdapter
{
    private ValidatorServiceInterface $validatorService;

    private RenewTokenSchema $schema;

    private TokenServiceInterface $tokenService;

    public function __construct(
        ValidatorServiceInterface $validatorService,
        RenewTokenSchema $schema,
        TokenServiceInterface $tokenService
    )
    {
        $this->validatorService = $validatorService;
        $this->schema = $schema;
        $this->tokenService = $tokenService;
    }

    /**
     * @param Request $request
     * @return RenewTokenQuery
     * @throws InvalidBodyException
     */
    public function from(Request $request)
    {
        $this->validatorService->make($request->all(), $this->schema->getRules());

        if ($this->validatorService->isFail())
        {
            throw new InvalidBodyException($this->validatorService->getErrors());
        }

        $token = $request->input('token');

        if(!$this->tokenService->exist($token)) {
            throw new InvalidBodyException("Token invalid, not exist");
        }

        return new RenewTokenQuery(
            $token,
        );
    }
}
