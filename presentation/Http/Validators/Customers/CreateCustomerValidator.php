<?php


namespace Presentation\Http\Validators\Customers;

use Presentation\Exceptions\InvalidBodyException;
use Presentation\Interfaces\ValidatorServiceInterface;

class CreateCustomerValidator implements CreateCustomerValidatorInterface
{
    private ValidatorServiceInterface $validator;

    public function __construct()
    {
        //$this->validator = $validator;
    }

    /**
     * @param array $all
     * @param array $rules
     * @param array $messages
     * @throws InvalidBodyException
     */
    public function validate($all, array $rules, array $messages): void
    {
        return;

        $this->validator->make($all, $rules);

        if(!$this->validator->isValid())
        {
            throw new InvalidBodyException($this->validator->getErrors());
        }
    }
}
