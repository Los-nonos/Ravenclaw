<?php


namespace Application\Queries\Handler\Payments;


use Application\Queries\Results\Payments\MercadoPagoExecuteResult;
use Application\Services\Customer\CustomerServiceInterface;
use Application\Services\Orders\OrderServiceInterface;
use Application\Services\Payments\MercadoPagoServiceInterface;
use Infrastructure\CommandBus\Handler\HandlerInterface;
use Infrastructure\QueryBus\Result\ResultInterface;

class MercadoPagoExecuteHandler implements HandlerInterface
{
    private MercadoPagoServiceInterface $mercadoPagoService;

    private OrderServiceInterface $orderService;

    private MercadoPagoExecuteResult $result;

    private CustomerServiceInterface $customerService;

    public function __construct(
        MercadoPagoServiceInterface $mercadoPagoService,
        OrderServiceInterface $orderService,
        MercadoPagoExecuteResult $result,
        CustomerServiceInterface $customerService
    )
    {
        $this->mercadoPagoService = $mercadoPagoService;
        $this->orderService = $orderService;
        $this->result = $result;
        $this->customerService = $customerService;
    }

    public function handle($command): ResultInterface
    {
        $this->mercadoPagoService->createClient($command->getAccessToken());

        $customer = $this->customerService->findCustomerByIdOrFail($command->getCustomerId());

        $payment = $this->mercadoPagoService->generatePayment(
                                                $command->getCartToken(),
                                                $command->getAmount(),
                                                $customer->getId());

        $payment->setPayerId($command->getEmailPayer());
        $payment->setPaymentId($command->getPaymentMethod());

        $order = $this->mercadoPagoService->execute($payment);

        $this->orderService->persist($order);

        $this->result->setOrder($order);
        return $this->result;
    }
}
