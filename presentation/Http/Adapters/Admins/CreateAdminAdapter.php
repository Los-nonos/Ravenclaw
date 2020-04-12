<?php


namespace Presentation\Http\Adapters\Admins;


use Application\Commands\Admins\CreateAdminCommand;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Admins\CreateAdminValidatorInterface;

class CreateAdminAdapter
{
    private CreateAdminValidatorInterface $validator;

    private array $rules = [
        'name' => 'bail|required|alpha',
        'surname' => 'bail|required|alpha',
        'username' => 'bail|required',
        'email' => 'bail|required|email',
        'password' => 'bail|required|min:8|max:15',
        'role' => 'bail|required|alpha'
    ];

    private array $messages = [

    ];

    public function __construct(CreateAdminValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function from(Request $request)
    {
        $this->validator->Validate($request->all(), $this->rules, $this->messages);

        return new CreateAdminCommand(
            $request->get('name'),
            $request->get('surname'),
            $request->get('username'),
            $request->get('email'),
            $request->get('password'),
            $request->get('role')
        );
    }
}
