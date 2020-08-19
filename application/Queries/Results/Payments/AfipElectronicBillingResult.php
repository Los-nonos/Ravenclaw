<?php


namespace Application\Queries\Results\Payments;


use Infrastructure\QueryBus\Result\ResultInterface;

class AfipElectronicBillingResult implements ResultInterface
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}
