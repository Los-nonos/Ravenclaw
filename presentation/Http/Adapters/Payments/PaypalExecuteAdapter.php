<?php


namespace Presentation\Http\Adapters\Payments;


use App\Exceptions\InvalidBodyException;
use Application\Commands\Command\Payments\PaypalExecuteCommand;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Schemas\Payments\PaypalExecuteSchema;
use Presentation\Http\Validators\Utils\ValidatorServiceInterface;

class PaypalExecuteAdapter
{
    private ValidatorServiceInterface $validator;

    private PaypalExecuteSchema $paypalExecuteSchema;

    public function __construct(ValidatorServiceInterface $validator, PaypalExecuteSchema $paypalExecuteSchema)
    {
        $this->validator = $validator;
        $this->paypalExecuteSchema = $paypalExecuteSchema;
    }

    /**
     * @param Request $request
     * @return PaypalExecuteCommand
     * @throws InvalidBodyException
     */
    public function from(Request $request)
    {
        $this->validator->make($request->all(), $this->paypalExecuteSchema->getRules());

        if(!$this->validator->isValid()) {
            throw new InvalidBodyException($this->validator->getErrors());
        }

        return new PaypalExecuteCommand(
            $request->get('paymentId'),
            $request->get('payerId'),
            $request->input('customer_id'),
            $request->input('access_token')
        );
    }
}
