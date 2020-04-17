<?php


namespace Application\Handlers\Payments;

use Application\Commands\Payments\PaypalExecuteCommand;
use Application\Results\Payments\PaypalExecuteResultInterface;
use Application\Services\Customers\CustomerServiceInterface;
use Application\Services\Orders\OrderServiceInterface;
use Application\Services\Payments\PaypalServiceInterface;
use Domain\Entities\Payment;

class PaypalExecuteHandler
{
    private PaypalExecuteResultInterface $result;

    private PaypalServiceInterface $paypalService;

    private OrderServiceInterface $orderService;

    private CustomerServiceInterface $customerService;

    public function __construct(
        PaypalServiceInterface $paypalService,
        OrderServiceInterface $orderService,
        PaypalExecuteResultInterface $result,
        CustomerServiceInterface $customerService
    )
    {
        $this->result = $result;
        $this->paypalService = $paypalService;
        $this->orderService = $orderService;
        $this->customerService = $customerService;
    }

    public function handle(PaypalExecuteCommand $command): PaypalExecuteResultInterface
    {
        $payment = new Payment();
        $payment->setPayerId($command->getPayerId());
        $payment->setPaymentId($command->getPaymentId());

        $customer = $this->customerService->findCustomerById($command->getCustomerId());

        $this->paypalService->CreateClient($customer->getClientTokenPaypal(), $command->getAccessToken());

        $order = $this->paypalService->execute($payment);

        $this->orderService->persist($order);

        $this->result->setOrder($order);
        return $this->result;
    }
}
