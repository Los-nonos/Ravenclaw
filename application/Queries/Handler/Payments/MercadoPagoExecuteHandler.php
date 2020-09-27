<?php


namespace Application\Queries\Handler\Payments;


use Application\Queries\Query\Payments\MercadoPagoExecuteQuery;
use Application\Queries\Results\Payments\MercadoPagoExecuteResult;
use Application\Services\Customer\CustomerServiceInterface;
use Application\Services\Orders\OrderServiceInterface;
use Infrastructure\Payments\Services\MercadoPagoService;
use Infrastructure\QueryBus\Handler\HandlerInterface;
use Infrastructure\QueryBus\Result\ResultInterface;

class MercadoPagoExecuteHandler implements HandlerInterface
{
    private MercadoPagoService $mercadoPagoService;

    private OrderServiceInterface $orderService;

    private MercadoPagoExecuteResult $result;

    private CustomerServiceInterface $customerService;

    public function __construct(
        MercadoPagoService $mercadoPagoService,
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

    /**
     * @param MercadoPagoExecuteQuery $command
     * @return ResultInterface
     */
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
        $order->setCustomer($customer);
        $this->orderService->persist($order);

        $this->result->setOrder($order);
        return $this->result;
    }
}
