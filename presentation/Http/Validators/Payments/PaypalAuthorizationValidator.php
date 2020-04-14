<?php


namespace Presentation\Http\Validators\Payments;


use Presentation\Exceptions\InvalidBodyException;
use Presentation\Interfaces\ValidatorServiceInterface;

class PaypalAuthorizationValidator
{
    private ValidatorServiceInterface $validatorService;

    public function __construct(ValidatorServiceInterface $validatorService)
    {
        $this->validatorService = $validatorService;
    }

    /**
     * @param $all
     * @param array $rules
     * @param array $messages
     * @throws InvalidBodyException
     */
    public function Validate($all, array $rules, array $messages)
    {
        $this->validatorService->make($all, $rules);

        if(!$this->validatorService->isValid())
        {
            throw new InvalidBodyException($this->validatorService->getErrors());
        }
    }
}
