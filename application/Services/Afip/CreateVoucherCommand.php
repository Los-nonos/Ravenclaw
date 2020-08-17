<?php


namespace Application\Services\Afip;

use Money\Money;

class CreateVoucherCommand
{
    private Money $total;
    private int $voucherQuantity;
    private int $pointOfSale;
    private string $typeVoucher;
    private string $buyerTypeDocument;
    private string $buyerDocumentNumber;
    private string $concept;

    public function getData() {
        return [

        ];
    }

    public function getTotalMoney(): Money
    {
        return $this->total;
    }

    public function getVoucherQuantity()
    {
        return $this->voucherQuantity ? $this->voucherQuantity : 1;
    }

    public function getPointOfSale()
    {
        return $this->pointOfSale ? $this->pointOfSale : 1;
    }

    public function getTypeVoucher()
    {
        return $this->typeVoucher;
    }

    public function getBuyerTypeDocument()
    {
        return $this->buyerTypeDocument;
    }

    public function getBuyerDocumentNumber()
    {
        return $this->buyerDocumentNumber;
    }

    public function getConcept()
    {
        return $this->concept;
    }
}
