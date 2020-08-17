<?php


namespace Application\Services\Afip;

use DateTimeImmutable;
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

    public function getTaxNet(): Money
    {

    }

    public function getTaxExempt(): Money
    {
    }

    public function getTotalIva(): Money
    {

    }

    public function getTotalTributes(): Money
    {
    }

    public function getInitDate(): DateTimeImmutable
    {
    }

    public function getEndDate(): DateTimeImmutable
    {
    }

    public function getExpirationDate(): DateTimeImmutable
    {
    }

    public function getAmountNotTaxed(): Money
    {
    }
}
