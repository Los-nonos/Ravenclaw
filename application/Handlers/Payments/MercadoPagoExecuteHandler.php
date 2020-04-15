<?php


namespace Application\Handlers\Payments;


use Application\Commands\Payments\MercadoPagoExecuteCommand;
use Application\Services\Orders\OrderServiceInterface;

class MercadoPagoExecuteHandler
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

    }
}
