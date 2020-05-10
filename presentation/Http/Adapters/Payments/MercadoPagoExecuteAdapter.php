<?php


namespace Presentation\Http\Adapters\Payments;


use App\Exceptions\InvalidBodyException;
use Application\Queries\Query\Payments\MercadoPagoExecuteQuery;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Schemas\Payments\MercadoPagoExecuteSchema;
use Presentation\Http\Validators\Utils\ValidatorServiceInterface;

class MercadoPagoExecuteAdapter
{
    private ValidatorServiceInterface $validator;

    private MercadoPagoExecuteSchema $pagoExecuteSchema;

    public function __construct(ValidatorServiceInterface $validator, MercadoPagoExecuteSchema $pagoExecuteSchema)
    {
        $this->validator = $validator;
        $this->pagoExecuteSchema = $pagoExecuteSchema;
    }

    /**
     * @param Request $request
     * @return MercadoPagoExecuteQuery
     * @throws InvalidBodyException
     */
    public function from(Request $request)
    {
        $this->validator->make($request->all(), $this->pagoExecuteSchema->getRules());

        if($this->validator->isFail()) {
            throw new InvalidBodyException($this->validator->getErrors());
        }

        return new MercadoPagoExecuteQuery(
            $request->input('access_token'),
            $request->input('amount'),
            $request->input('email_payer'),
            $request->input('cart_token'),
            $request->input('payment_method'),
            $request->input('customer_id')
        );
    }
}
