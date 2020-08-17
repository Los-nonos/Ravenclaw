<?php


namespace Application\Services\Afip;


use Infrastructure\Afip\Afip;

class AfipServices
{
    /**
     * @var Afip
     */
    private Afip $afip;

    public function initService(string $cuit) {
        $this->afip = new Afip(['CUIT' => $cuit]);
    }

    public function createVoucher(CreateVoucherCommand $data) {
        $this->afip->ElectronicBilling->CreateVoucher($data->getData());
    }
}
