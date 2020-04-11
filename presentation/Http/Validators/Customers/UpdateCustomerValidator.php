<?php


namespace Presentation\Http\Validators\Customers;


use Presentation\Exceptions\InvalidBodyException;
use Presentation\Interfaces\ValidatorServiceInterface;

class UpdateCustomerValidator implements UpdateCustomerValidatorInterface
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
    public function validate($all, array $rules, array $messages): void
    {
        $this->validatorService->make($all, $rules);

        if(!$this->validatorService->isValid())
        {
            throw new InvalidBodyException($this->validatorService->getErrors());
        }
    }
}
