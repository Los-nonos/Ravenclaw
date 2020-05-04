<?php


namespace Presentation\Http\Adapters\Customers;

use App\Exceptions\InvalidBodyException;
use Illuminate\Http\Request;
use Application\Commands\Command\Customers\CreateCustomerCommand;
use Presentation\Http\Validators\Schemas\Customer\CreateCustomerSchema;
use Presentation\Http\Validators\Utils\ValidatorServiceInterface;

class CreateCustomerAdapter
{
    private ValidatorServiceInterface $validator;

    private CreateCustomerSchema $createCustomerSchema;

    public function __construct(ValidatorServiceInterface $validator, CreateCustomerSchema $createCustomerSchema)
    {
        $this->validator = $validator;
        $this->createCustomerSchema = $createCustomerSchema;
    }

    /**
     * @param Request $request
     * @return CreateCustomerCommand
     * @throws InvalidBodyException
     */
    public function from(Request $request): CreateCustomerCommand
    {
        $this->validator->make($request->all(), $this->createCustomerSchema->getRules());

        if(!$this->validator->isValid()) {
            throw new InvalidBodyException($this->validator->getErrors());
        }

        return new CreateCustomerCommand(
            $request->get('name'),
            $request->get('surname'),
            $request->get('username'),
            $request->get('email'),
            $request->get('password'),
            $request->get('domain'),
            $request->get('organizationName')
        );
    }
}
