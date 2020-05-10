<?php


namespace Presentation\Http\Adapters\Customers;


use App\Exceptions\InvalidBodyException;
use Application\Commands\Command\Customers\DestroyCustomerByIdCommand;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Schemas\Customer\DestroyCustomerByIdSchema;
use Presentation\Http\Validators\Utils\ValidatorServiceInterface;

class DestroyCustomerByIdAdapter
{
    private ValidatorServiceInterface $validatorService;

    private DestroyCustomerByIdSchema $schema;

    public function __construct(
        ValidatorServiceInterface $validatorService,
        DestroyCustomerByIdSchema $schema
    )
    {
        $this->validatorService = $validatorService;
        $this->schema = $schema;
    }

    /**
     * @param Request $request
     * @return DestroyCustomerByIdCommand
     * @throws InvalidBodyException
     */
    public function from(Request $request)
    {
        $this->validatorService->make($request->all(), $this->schema->getRules());

        if($this->validatorService->isFail())
        {
            throw new InvalidBodyException($this->validatorService->getErrors());
        }

        return new DestroyCustomerByIdCommand($request->input('id'), $request->input('admin_id'));
    }
}
