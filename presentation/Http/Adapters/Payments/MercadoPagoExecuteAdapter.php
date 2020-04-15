<?php


namespace Presentation\Http\Adapters\Payments;


use Application\Commands\Payments\MercadoPagoExecuteCommand;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Payments\MercadoPagoExecuteValidatorInterface;

class MercadoPagoExecuteAdapter
{
    private MercadoPagoExecuteValidatorInterface $validator;

    private array $rules = [

    ];

    private array $messages = [

    ];

    public function __construct(MercadoPagoExecuteValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function from(Request $request)
    {
        $this->validator->Validate($request->all(), $this->rules, $this->messages);

        return new MercadoPagoExecuteCommand(

        );
    }
}
