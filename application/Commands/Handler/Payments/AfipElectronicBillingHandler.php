<?php


namespace Application\Commands\Handler\Payments;


use Application\Commands\Command\Payments\AfipElectronicBillingCommand;
use Application\Exceptions\FailedPaymentException;
use Application\Queries\Results\Payments\AfipElectronicBillingResult;
use Application\Services\Afip\AfipServices;
use Application\Services\Afip\CreateVoucherCommand;
use Application\Services\Customer\CustomerServiceInterface;
use Infrastructure\CommandBus\Handler\HandlerInterface;

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
   * @param AfipElectronicBillingCommand $command
   * @throws FailedPaymentException
   */
    public function handle($command): void
    {
        $user = $this->userService->findCustomerByIdOrFail($command->getCustomerId());

        $this->afipServices->initService($user->getCuit());

        $voucher = new CreateVoucherCommand(
            $command->getTotalMoney(),
            $command->getVoucherQuantity(),
            $command->getPointOfSale(),
            $command->getTypeVoucher(),
            $command->getPurchaserTypeDocument(),
            $command->getPurchaserNumberDocument(),
            $command->getConcept(),
            $command->getTaxNet(),
            $command->getTaxExempt(),
            $command->getTotalIva(),
            $command->getTotalTributes(),
            $command->getAmountNotTaxed(),
            $command->getInitDate(),
            $command->getEndDate(),
            $command->getExpirationDate(),
        );

        $data = $this->afipServices->createVoucher($voucher);

        //TODO: add data into new payment and persist
    }
}
