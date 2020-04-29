<?php


namespace Presentation\Http\Adapters\Customers;


use App\Exceptions\InvalidBodyException;
use Application\Queries\Query\Customers\ShowCustomerByIdQuery;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Schemas\Customer\ShowCustomerByIdSchema;
use Presentation\Http\Validators\Utils\ValidatorServiceInterface;

class ShowCustomerByIdAdapter
{
    private ValidatorServiceInterface $validatorService;

    private ShowCustomerByIdSchema $showCustomerSchema;

    public function __construct(
        ValidatorServiceInterface $validatorService,
        ShowCustomerByIdSchema $showCustomerSchema
    )
    {
        $this->validatorService = $validatorService;
        $this->showCustomerSchema = $showCustomerSchema;
    }

    /**
     * @param Request $request
     * @return ShowCustomerByIdQuery
     * @throws InvalidBodyException
     */
    public function from(Request $request)
    {
        $this->validatorService->make($request->all(), $this->showCustomerSchema->getRules());

        if(!$this->validatorService->isValid())
        {
            throw new InvalidBodyException($this->validatorService->getErrors());
        }

        return new ShowCustomerByIdQuery(
            $request->get('id')
        );
    }
}
