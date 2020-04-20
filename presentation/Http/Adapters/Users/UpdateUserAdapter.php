<?php


namespace Presentation\Http\Adapters\Users;

use Illuminate\Http\Request;
use Application\Commands\Command\Users\UpdateUserCommand;
use Presentation\Http\Validators\Users\UpdateUserValidatorInterface;

class UpdateUserAdapter
{
    private UpdateUserValidatorInterface $validator;

    private array $rules = [
        'id' => 'bail|required|min:0|integer',
        'name' => 'bail|required|alpha',
        'surname' => 'bail|required|alpha',
        'username' => 'bail|required',
        'email' => 'bail|required|email',
    ];

    private array $messages = [
        'id.integer' => 'The id must be an integer',
        'id.min' => 'The id should more than 0',
        'id.required' => 'The id is required',
        'name.required' => 'The name is required',
        'name.alpha' => 'The name cannot contain numbers or symbols',
        'surname.required' => 'The surname is required',
        'surname.alpha' => 'The surname cannot contain numbers or symbols',
        'email.required' => 'The email is required',
        'email.email' => 'The email is not correct',
        'username.required' => 'The username is required',
        'username.alpha' => 'The username cannot contain numbers or symbols',
    ];

    public function __construct(UpdateUserValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function from(Request $request)
    {
        $this->validator->validate($request->all(), $this->rules, $this->messages);

        return new UpdateUserCommand(
            $request->get('id'),
            $request->get('name'),
            $request->get('surname'),
            $request->get('username'),
            $request->get('email'),
        );
    }
}
