<?php


namespace Presentation\Http\Adapters\Payments;


use App\Exceptions\InvalidBodyException;
use Application\Commands\Command\Payments\MercadoPagoExecuteCommand;
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
     * @return MercadoPagoExecuteCommand
     * @throws InvalidBodyException
     */
    public function from(Request $request)
    {
        $this->validator->make($request->all(), $this->pagoExecuteSchema->getRules());

        if(!$this->validator->isValid()) {
            throw new InvalidBodyException($this->validator->getErrors());
        }

        return new MercadoPagoExecuteCommand(

        );
    }
}
