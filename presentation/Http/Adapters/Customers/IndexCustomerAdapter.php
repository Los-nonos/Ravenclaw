<?php


namespace Presentation\Http\Adapters\Customers;

use Application\Queries\Query\Customers\IndexCustomerQuery;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Customers\IndexCustomerValidatorInterface;

class IndexCustomerAdapter
{
    private IndexCustomerValidatorInterface $validator;

    private array $rules = [
        'page' => 'bail|integer|min:0',
        'size' => 'bail|integer|min:0',
        'name' => 'bail|alpha',
        'surname' => 'bail|alpha',
        'username' => 'bail',
        'email' => 'bail|email',
        'organization_name' => 'bail|alpha',
        'domain' => 'bail',
    ];

    private array $messages = [

    ];

    public function __construct(IndexCustomerValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function from(Request $request)
    {
        $this->validator->validate($request->all(), $this->rules, $this->messages);

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
