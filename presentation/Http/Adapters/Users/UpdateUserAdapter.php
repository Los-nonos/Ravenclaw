<?php


namespace Presentation\Http\Adapters\Users;

use App\Exceptions\InvalidBodyException;
use Illuminate\Http\Request;
use Application\Commands\Command\Users\UpdateUserCommand;
use Presentation\Http\Validators\Schemas\Users\UpdateUserSchema;
use Presentation\Http\Validators\Utils\ValidatorServiceInterface;

class UpdateUserAdapter
{
    private ValidatorServiceInterface $validator;

    private UpdateUserSchema $updateUserSchema;

    public function __construct(ValidatorServiceInterface $validator, UpdateUserSchema $updateUserSchema)
    {
        $this->validator = $validator;
        $this->updateUserSchema = $updateUserSchema;
    }

    /**
     * @param Request $request
     * @return UpdateUserCommand
     * @throws InvalidBodyException
     */
    public function from(Request $request)
    {
        $this->validator->make($request->all(), $this->updateUserSchema->getRules());

        if($this->validator->isFail()) {
            throw new InvalidBodyException($this->validator->getErrors());
        }

        return new UpdateUserCommand(
            $request->get('id'),
            $request->get('name'),
            $request->get('surname'),
            $request->get('username'),
            $request->get('email'),
        );
    }
}
