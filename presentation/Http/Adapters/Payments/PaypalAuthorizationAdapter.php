<?php


namespace Presentation\Http\Adapters\Payments;


use Application\Commands\Payments\PayPalAuthorizationCommand;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Payments\PaypalAuthorizationValidatorInterface;

class PaypalAuthorizationAdapter
{
    private PaypalAuthorizationValidatorInterface $validator;

    public function __construct(PaypalAuthorizationValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    private array $rules = [
        'customer_id' => 'bail|required|min:0|integer',
        'amount' => 'bail|required|min:0'
    ];

    private array $messages = [

    ];

    /**
     * @param Request $request
     * @return PayPalAuthorizationCommand
     */
    public function from(Request $request)
    {
        $this->validator->Validate($request->all(), $this->rules, $this->messages);

        return new PaypalAuthorizationCommand(
            $request->get('customer_id'),
            $request->get('amount')
        );
    }
}
