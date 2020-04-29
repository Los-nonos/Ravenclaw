<?php


namespace Presentation\Http\Adapters\Admins;


use App\Exceptions\InvalidBodyException;
use Application\Commands\Command\Admins\CreateAdminCommand;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Schemas\Admin\CreateAdminSchema;
use Presentation\Http\Validators\Utils\ValidatorServiceInterface;

class CreateAdminAdapter
{
    private ValidatorServiceInterface $validator;

    private CreateAdminSchema $createAdminSchema;

    public function __construct(ValidatorServiceInterface $validator, CreateAdminSchema $createAdminSchema)
    {
        $this->validator = $validator;
        $this->createAdminSchema = $createAdminSchema;
    }

    /**
     * @param Request $request
     * @return CreateAdminCommand
     * @throws InvalidBodyException
     */
    public function from(Request $request)
    {
        $this->validator->make($request->all(), $this->createAdminSchema->getRules());

        if(!$this->validator->isValid()) {
            throw new InvalidBodyException($this->validator->getErrors());
        }

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
