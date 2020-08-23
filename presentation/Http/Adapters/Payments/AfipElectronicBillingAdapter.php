<?php


namespace Presentation\Http\Adapters\Payments;


use App\Exceptions\InvalidBodyException;
use Application\Queries\Query\Payments\AfipElectronicBillingQuery;
use Illuminate\Http\Request;
use Presentation\Http\Validators\Utils\ValidatorServiceInterface;

class AfipElectronicBillingAdapter
{
    private ValidatorServiceInterface $validatorService;

    public function __construct(ValidatorServiceInterface $validatorService)
    {
        $this->validatorService = $validatorService;
    }

    public function from(Request $request) {

        $this->validatorService->make($request->all(), []);

        if ($this->validatorService->isFail()) {
            throw new InvalidBodyException($this->validatorService->getErrors());
        }

        return new AfipElectronicBillingQuery(
            $request->input('customer_id'),
            $request->input('totalAmount'),
            $request->input('voucherQuantity'),
            $request->input('pointOfSale'),
            $request->input('typeVoucher'),
            $request->input('purchaserTypeDocument'),
            $request->input('purchaserNumberDocument'),
            $request->input('concept'),
            $request->input('taxNet'),
            $request->input('taxExempt'),
            $request->input('totalIva'),
            $request->input('totalTributes'),
            $request->input('amountNotTaxed'),
            $request->input('initDate'),
            $request->input('endDate'),
            $request->input('expirationDate'),
        );
    }
}
