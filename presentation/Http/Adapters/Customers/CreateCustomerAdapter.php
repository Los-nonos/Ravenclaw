<?php


namespace Presentation\Http\Adapters\Customers;

use Illuminate\Http\Request;
use Presentation\Http\Validators\Customers\CreateCustomerValidatorInterface;
use Application\Commands\Customers\CreateCustomerCommand;

class CreateCustomerAdapter
{
    private CreateCustomerValidatorInterface $validator;

    private $messages = [
        'id.integer' => 'The id must be an integer',
        'name.required' => 'The name is required',
        'name.alpha' => 'The name cannot contain numbers or symbols',
        'email.required' => 'The email is required',
        'email.email' => 'The email is not correct',
        'password.required' => 'The password is required',
        'password.min' => 'The password is too short',
        'password.max' => 'The password is too long'
    ];

    private $rules = [
        'name' => 'bail|required|alpha',
        'surname' => 'bail|required|alpha',
        'username' => 'bail|required',
        'email' => 'bail|required|email',
        'password' => 'bail|required|min:4|max:16',
        'domain' => 'bail|required',
        'organizationName' => 'bail|required',
    ];

    public function __construct(CreateCustomerValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function from(Request $request): CreateCustomerCommand
    {
        $this->validator->validate($request->all(), $this->rules, $this->messages);

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
