<?php


namespace Presentation\Http\Adapters\Payments;


use App\Exceptions\InvalidBodyException;
use Application\Queries\Query\Payments\PayPalAuthorizationQuery;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Schemas\Payments\PaypalAuthorizationSchema;
use Presentation\Http\Validators\Utils\ValidatorServiceInterface;

class PaypalAuthorizationAdapter
{
    private ValidatorServiceInterface $validator;

    public function __construct(ValidatorServiceInterface $validator, PaypalAuthorizationSchema $paypalAuthorizationSchema)
    {
        $this->validator = $validator;
        $this->paypalAuthorizationSchema = $paypalAuthorizationSchema;
    }

    private PaypalAuthorizationSchema $paypalAuthorizationSchema;

    /**
     * @param Request $request
     * @return PayPalAuthorizationQuery
     * @throws InvalidBodyException
     */
    public function from(Request $request)
    {
        $this->validator->make($request->all(), $this->paypalAuthorizationSchema->getRules());

        if(!$this->validator->isValid()) {
            throw new InvalidBodyException($this->validator->getErrors());
        }

        return new PayPalAuthorizationQuery(
            $request->get('customer_id'),
            $request->get('amount')
        );
    }
}
