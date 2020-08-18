<?php


namespace Presentation\Http\Adapters\Payments;


use App\Exceptions\InvalidBodyException;
use Application\Queries\Query\Payments\AfipElectronicBillingQuery;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Utils\ValidatorServiceInterface;

class AfipElectronicBillingAdapter
{
    private ValidatorServiceInterface $validatorService;

    public function __construct(ValidatorServiceInterface $validatorService)
    {
        $this->validatorService = $validatorService;
    }

    public function from(Request $request) {

        $this->validatorService->make($request->all(), []);

        if ($this->validatorService->isFail()) {
            throw new InvalidBodyException($this->validatorService->getErrors());
        }

        return new AfipElectronicBillingQuery();
    }
}
