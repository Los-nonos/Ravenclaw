<?php


namespace Presentation\Http\Adapters\Payments;


use Application\Commands\Payments\PaypalExecuteCommand;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Payments\PaypalExecuteValidatorInterface;

class PaypalExecuteAdapter
{
    private PaypalExecuteValidatorInterface $validator;

    private array $rules = [
        'paymentId' => 'bail|required|alpha',
        'payerId' => 'bail|required|alpha'
    ];

    private array $messages = [

    ];

    public function __construct(PaypalExecuteValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function from(Request $request)
    {
        $this->validator->Validate($request->all(), $this->rules, $this->messages);

        return new PaypalExecuteCommand(
            $request->get('paymentId'),
            $request->get('payerId')
        );
    }
}
