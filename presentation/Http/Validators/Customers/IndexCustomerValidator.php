<?php


namespace Presentation\Http\Validators\Customers;


use App\Exceptions\InvalidBodyException;
use Presentation\Http\Validators\Utils\ValidatorServiceInterface;

class IndexCustomerValidator implements IndexCustomerValidatorInterface
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
    public function validate($all, array $rules, array $messages)
    {
        $this->validatorService->make($all, $rules);

        if(!$this->validatorService->isValid())
        {
            throw new InvalidBodyException($this->validatorService->getErrors());
        }
    }
}
