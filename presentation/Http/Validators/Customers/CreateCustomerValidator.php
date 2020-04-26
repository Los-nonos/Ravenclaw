<?php


namespace Presentation\Http\Validators\Customers;

use App\Exceptions\InvalidBodyException;
use Presentation\Http\Validators\Utils\ValidatorServiceInterface;

class CreateCustomerValidator implements CreateCustomerValidatorInterface
{
    private ValidatorServiceInterface $validator;

    public function __construct(ValidatorServiceInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param array $all
     * @param array $rules
     * @param array $messages
     * @throws InvalidBodyException
     */
    public function validate($all, array $rules, array $messages): void
    {
        $this->validator->make($all, $rules);

        if(!$this->validator->isValid())
        {
            throw new InvalidBodyException($this->validator->getErrors());
        }
    }
}
