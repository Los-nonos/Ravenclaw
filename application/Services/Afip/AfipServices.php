<?php


namespace Application\Services\Afip;


use Application\Exceptions\FailedPaymentException;
use Infrastructure\Afip\Afip;
use Infrastructure\Afip\Services\ElectronicBilling;
use Infrastructure\Afip\Transformers\CreateVoucherTransformer;

final class AfipServices
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

    public function createVoucher(CreateVoucherCommand $data): array {
        if (!isset($this->afip)) {
            throw new FailedPaymentException('¡client not generated!');
        }

        $electronicBilling = new ElectronicBilling($this->afip);

        return $electronicBilling->CreateNextVoucher($this->createVoucherTransformer->transform($data));
    }
}
