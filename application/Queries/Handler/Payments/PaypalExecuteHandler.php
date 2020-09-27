<?php


namespace Application\Queries\Handler\Payments;

use Application\Queries\Query\Payments\PaypalExecuteQuery;
use Application\Queries\Results\Payments\PaypalExecuteResult;
use Application\Services\Customer\CustomerServiceInterface;
use Application\Services\Orders\OrderServiceInterface;
use Domain\ValueObjects\Payment;
use Infrastructure\CommandBus\Handler\HandlerInterface;
use Infrastructure\Payments\Services\PaypalService;
use Infrastructure\QueryBus\Result\ResultInterface;
use Money\Currency;
use Money\Money;

class PaypalExecuteHandler implements HandlerInterface
{
    private PaypalExecuteResult $result;

    private PaypalService $paypalService;

    private OrderServiceInterface $orderService;

    private CustomerServiceInterface $customerService;

    public function __construct(
        PaypalService $paypalService,
        OrderServiceInterface $orderService,
        PaypalExecuteResult $result,
        CustomerServiceInterface $customerService
    )
    {
        $this->result = $result;
        $this->paypalService = $paypalService;
        $this->orderService = $orderService;
        $this->customerService = $customerService;
    }

    /**
     * @param PaypalExecuteQuery $command
     * @return ResultInterface
     */
    public function handle($command): ResultInterface
    {
        $payment = new Payment(new Money(0, new Currency('ARS')));
        $payment->setPayerId($command->getPayerId());
        $payment->setPaymentId($command->getPaymentId());

        $this->customerService->findCustomerByIdOrFail($command->getCustomerId());

        $this->paypalService->execute($payment);

        return $this->result;
    }
}
