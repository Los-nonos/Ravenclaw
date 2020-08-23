<?php


namespace Application\Queries\Handler\Payments;


use Application\Queries\Query\Payments\AfipElectronicBillingQuery;
use Application\Queries\Results\Payments\AfipElectronicBillingResult;
use Application\Services\Afip\AfipServices;
use Application\Services\Afip\CreateVoucherCommand;
use Application\Services\Customer\CustomerServiceInterface;
use Infrastructure\QueryBus\Handler\HandlerInterface;
use Infrastructure\QueryBus\Result\ResultInterface;

class AfipElectronicBillingHandler implements HandlerInterface
{
    /**
     * @var AfipServices
     */
    private AfipServices $afipServices;

    /**
     * @var CustomerServiceInterface
     */
    private CustomerServiceInterface $userService;

    public function __construct(
        AfipServices $afipServices,
        CustomerServiceInterface $userService
    ) {
        $this->afipServices = $afipServices;
        $this->userService = $userService;
    }

    /**
     * @param AfipElectronicBillingQuery $query
     * @return ResultInterface
     */
    public function handle($query): ResultInterface
    {
        $user = $this->userService->findCustomerByIdOrFail($query->getCustomerId());

        $this->afipServices->initService($user->getCuit());

        $voucher = new CreateVoucherCommand(
            $query->getTotalMoney(),
            $query->getVoucherQuantity(),
            $query->getPointOfSale(),
            $query->getTypeVoucher(),
            $query->getPurchaserTypeDocument(),
            $query->getPurchaserNumberDocument(),
            $query->getConcept(),
            $query->getTaxNet(),
            $query->getTaxExempt(),
            $query->getTotalIva(),
            $query->getTotalTributes(),
            $query->getAmountNotTaxed(),
            $query->getInitDate(),
            $query->getEndDate(),
            $query->getExpirationDate(),
        );

        $data = $this->afipServices->createVoucher($voucher);

        return new AfipElectronicBillingResult($data);
    }
}
