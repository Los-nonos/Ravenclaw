<?php


namespace Application\Queries\Handler\Payments;

use Application\Queries\Results\Payments\PaypalExecuteResult;
use Application\Services\Customer\CustomerServiceInterface;
use Application\Services\Orders\OrderServiceInterface;
use Application\Services\Payments\PaypalServiceInterface;
use Domain\Entities\Payment;
use Infrastructure\CommandBus\Handler\HandlerInterface;
use Infrastructure\QueryBus\Result\ResultInterface;

class PaypalExecuteHandler implements HandlerInterface
{
    private PaypalExecuteResult $result;

    private PaypalServiceInterface $paypalService;

    private OrderServiceInterface $orderService;

    private CustomerServiceInterface $customerService;

    public function __construct(
        PaypalServiceInterface $paypalService,
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

    public function handle($command): ResultInterface
    {
        $payment = new Payment();
        $payment->setPayerId($command->getPayerId());
        $payment->setPaymentId($command->getPaymentId());

        $customer = $this->customerService->findCustomerByIdOrFail($command->getCustomerId());

        $this->paypalService->CreateClient($customer->getClientTokenPaypal(), $command->getAccessToken());

        $order = $this->paypalService->execute($payment);

        $this->orderService->persist($order);

        $this->result->setOrder($order);
        return $this->result;
    }
}
