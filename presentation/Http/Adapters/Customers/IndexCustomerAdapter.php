<?php


namespace Presentation\Http\Adapters\Customers;

use App\Exceptions\InvalidBodyException;
use Application\Queries\Query\Customers\IndexCustomerQuery;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Schemas\Customer\IndexCustomerSchema;
use Presentation\Http\Validators\Utils\ValidatorServiceInterface;

class IndexCustomerAdapter
{
    private ValidatorServiceInterface $validator;

    private IndexCustomerSchema $indexCustomerSchema;

    public function __construct(ValidatorServiceInterface $validator, IndexCustomerSchema $indexCustomerSchema)
    {
        $this->validator = $validator;
        $this->indexCustomerSchema = $indexCustomerSchema;
    }

    /**
     * @param Request $request
     * @return IndexCustomerQuery
     * @throws InvalidBodyException
     */
    public function from(Request $request)
    {
        $this->validator->make($request->all(), $this->indexCustomerSchema->getRules());

        if($this->validator->isFail()) {
            throw new InvalidBodyException($this->validator->getErrors());
        }

        return new IndexCustomerQuery(
            $request->get('page'),
            $request->get('size'),
            $request->get('name'),
            $request->get('surname'),
            $request->get('username'),
            $request->get('email'),
            $request->get('organization_name'),
            $request->get('domain'),
        );
    }
}
