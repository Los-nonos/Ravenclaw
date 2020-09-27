<?php


namespace Infrastructure\Payments;


use Application\Services\Payments\PaypalService;
use Domain\Enums\State;
use Domain\ValueObjects\Payment;
use Exception;
use Infrastructure\Payments\Interfaces\PaymentGateway;

class PaypalGateway implements PaymentGateway
{
    /**
     * @var PaypalService
     */
    private PaypalService $paypalService;

    public function __construct(PaypalService $paypalService)
    {
        $this->paypalService = $paypalService;
    }


    public function process(Payment $payment): Payment
    {
        if ($payment->getLastStatus() !== State::AUTHORIZED) {
            throw new Exception("can not process this payment");
        }

        $payment = $this->paypalService->execute($payment);

        return $payment;
    }
}
