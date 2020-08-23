<?php


namespace Application\Queries\Query\Payments;


use DateTimeImmutable;
use Infrastructure\QueryBus\Query\QueryInterface;
use Money\Money;

class AfipElectronicBillingQuery implements QueryInterface
{
    private int $customerId;
    private Money $total;
    private int $voucherQuantity;
    private int $pointOfSale;
    private string $typeVoucher;
    private string $purchaserTypeDocument;
    private string $purchaserNumberDocument;
    private string $concept;
    private Money $taxNet;
    private Money $taxExempt;
    private Money $totalIva;
    private Money $totalTributes;
    private ?DateTimeImmutable $initDate;
    private ?DateTimeImmutable $endDate;
    private ?DateTimeImmutable $expirationDate;
    private Money $amountNotTaxed;

    public function __construct(
        int $customerId,
        Money $total,
        int $voucherQuantity,
        int $pointOfSale,
        string $typeVoucher,
        string $purchaserTypeDocument,
        string $purchaserNumberDocument,
        string $concept,
        Money $taxNet,
        Money $taxExempt,
        Money $totalIva,
        Money $totalTributes,
        Money $amountNotTaxed,
        DateTimeImmutable $initDate = null,
        DateTimeImmutable $endDate = null,
        DateTimeImmutable $expirationDate = null
    ) {
        $this->customerId = $customerId;
        $this->total = $total;
        $this->voucherQuantity = $voucherQuantity;
        $this->pointOfSale = $pointOfSale;
        $this->typeVoucher = $typeVoucher;
        $this->purchaserTypeDocument = $purchaserTypeDocument;
        $this->purchaserNumberDocument = $purchaserNumberDocument;
        $this->concept = $concept;
        $this->taxNet = $taxNet;
        $this->taxExempt = $taxExempt;
        $this->totalIva = $totalIva;
        $this->totalTributes = $totalTributes;
        $this->amountNotTaxed = $amountNotTaxed;
        $this->initDate = $initDate;
        $this->endDate = $endDate;
        $this->expirationDate = $expirationDate;
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

    public function getPurchaserTypeDocument()
    {
        return $this->purchaserTypeDocument;
    }

    public function getPurchaserNumberDocument()
    {
        return $this->purchaserNumberDocument;
    }

    public function getConcept()
    {
        return $this->concept;
    }

    public function getTaxNet(): Money
    {
        return $this->taxNet;
    }

    public function getTaxExempt(): Money
    {
        return $this->taxExempt;
    }

    public function getTotalIva(): Money
    {
        return $this->totalIva;
    }

    public function getTotalTributes(): Money
    {
        return $this->totalTributes;
    }

    public function getInitDate(): ?DateTimeImmutable
    {
        return $this->initDate;
    }

    public function getEndDate(): ?DateTimeImmutable
    {
        return $this->endDate;
    }

    public function getExpirationDate(): ?DateTimeImmutable
    {
        return $this->expirationDate;
    }

    public function getAmountNotTaxed(): Money
    {
        return $this->amountNotTaxed;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }
}
