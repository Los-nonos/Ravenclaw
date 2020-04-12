<?php


namespace Presentation\Http\Adapters\Payments;


use Application\Commands\Payments\PayPalAuthorizationCommand;
use Application\Exceptions\InvalidServicePaymentException;
use Illuminate\Http\Request;
use Presentation\Exceptions\InvalidBodyException;
use Presentation\Http\Validators\Payments\PaymentAuthorizationValidatorInterface;

class PaymentAuthorizationAdapter
{
    private PaymentAuthorizationValidatorInterface $validator;

    public function __construct(PaymentAuthorizationValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    private array $rules = [

    ];

    private array $messages = [

    ];

    /**
     * @param Request $request
     * @return PayPalAuthorizationCommand
     * @throws InvalidServicePaymentException
     */
    public function from(Request $request)
    {
        $this->validator->Validate($request->all(), $this->rules, $this->messages);

        $type = $request->get('type');

        if($type == 'paypal')
        {
            return new PaypalAuthorizationCommand(
                $request->get('customer_id'),
                $request->get('amount')
            );
        }
        else{
            throw new InvalidServicePaymentException();
        }
    }
}
