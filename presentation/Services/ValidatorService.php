<?php


namespace Presentation\Services;

use Illuminate\Validation\Factory;
use Presentation\Interfaces\ValidatorServiceInterface;

class ValidatorService implements ValidatorServiceInterface
{

    private Factory $validatorFactory;
    private $validated;

    public function __construct(Factory $validatorFactory)
    {
        $this->validatorFactory = $validatorFactory;
    }

    public function make(array $options, array $rules)
    {
        $this->validated = $this->validatorFactory->make($options, $rules);

    }

    public function isValid()
    {
        return !$this->validated->fails();
    }

    public function getErrors()
    {
        return $this->validated->errors();
    }

    public function getValidator()
    {
        return $this->validated;
    }
}
