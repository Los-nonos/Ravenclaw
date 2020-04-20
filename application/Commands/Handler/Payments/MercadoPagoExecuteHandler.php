<?php


namespace Application\Commands\Handler\Payments;


use Application\Commands\Command\Payments\MercadoPagoExecuteCommand;
use Application\Services\Orders\OrderServiceInterface;
use Application\Services\Payments\MercadoPagoServiceInterface;
use Infrastructure\CommandBus\Handler\HandlerInterface;

class MercadoPagoExecuteHandler implements HandlerInterface
{
    private MercadoPagoServiceInterface $mercadoPagoService;

    private OrderServiceInterface $orderService;

    private MercadoPagoResultInterface $result;

    public function __construct(
        MercadoPagoServiceInterface $mercadoPagoService,
        OrderServiceInterface $orderService,
        MercadoPagoResultInterface $result
    )
    {
        $this->mercadoPagoService = $mercadoPagoService;
        $this->orderService = $orderService;
        $this->result = $result;
    }

    public function handle(MercadoPagoExecuteCommand $command)
    {
        $this->mercadoPagoService->CreateClient($command->getAccessToken());

        $payment = $this->mercadoPagoService->GeneratePayment(
                                                $command->getCartToken(),
                                                $command->getAmount());
        $payment->setPayerId($command->getEmailPayer());
        $payment->setPaymentId($command->getPaymentMethod());

        $order = $this->mercadoPagoService->Execute($payment);

        $this->orderService->Persist($order);

        $this->result->setOrder($order);
        return $this->result;
    }
}
