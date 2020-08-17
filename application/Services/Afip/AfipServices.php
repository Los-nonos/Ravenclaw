<?php


namespace Application\Services\Afip;


use Infrastructure\Afip\Afip;
use Infrastructure\Afip\Services\ElectronicBilling;
use Infrastructure\Afip\Transformers\CreateVoucherTransformer;

class AfipServices
{
    /**
     * @var Afip
     */
    private Afip $afip;

    private CreateVoucherTransformer $createVoucherTransformer;

    public function __construct(CreateVoucherTransformer $createVoucherTransformer)
    {
        $this->createVoucherTransformer = $createVoucherTransformer;
    }

    public function initService(string $cuit) {
        $this->afip = new Afip(['CUIT' => $cuit]);
    }

    public function createVoucher(CreateVoucherCommand $data) {
        $electronicBilling = new ElectronicBilling($this->afip);

        $electronicBilling->CreateVoucher($this->createVoucherTransformer->transform($data));
    }
}
