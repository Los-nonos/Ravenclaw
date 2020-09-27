<?php


namespace Application\Queries\Handler\Payments;


use Application\Exceptions\InvalidPayment;
use Application\Queries\Query\Payments\ProcessPaymentQuery;
use Application\Queries\Results\Payments\ProcessPaymentResult;
use Application\Services\Customer\CustomerServiceInterface;
use Application\Services\Payments\PaymentService;
use Infrastructure\Payments\Exceptions\GatewayNotFound;
use Infrastructure\Payments\Factories\PaymentGatewayFactory;
use Infrastructure\QueryBus\Handler\HandlerInterface;
use Infrastructure\QueryBus\Query\QueryInterface;
use Infrastructure\QueryBus\Result\ResultInterface;
use Money\Currency;
use Money\Money;
use Money\UnknownCurrencyException;

class ProcessPaymentHandler implements HandlerInterface
{
    private PaymentGatewayFactory $paymentGatewayFactory;

    private PaymentService $paymentService;

    private CustomerServiceInterface $customerService;

    public function __construct(
        PaymentGatewayFactory $paymentGatewayFactory,
        PaymentService $paymentService,
        CustomerServiceInterface $customerService
    ){
        $this->paymentGatewayFactory = $paymentGatewayFactory;
        $this->paymentService = $paymentService;
        $this->customerService = $customerService;
    }

    /**
     * @param ProcessPaymentQuery $query
     * @return ResultInterface
     * @throws InvalidPayment|GatewayNotFound|UnknownCurrencyException
     */
    public function handle($query): ResultInterface
    {
        $amount = new Money($query->getAmount(), new Currency($query->getCurrency()));

        $customer = $this->customerService->findCustomerByIdOrFail($query->getCustomerId());

        $payment = $this->paymentService->create($amount, $customer, $query->getGatewayId());

        $gateway = $this->paymentGatewayFactory->create($payment->getGateway());

        $payment = $gateway->process($payment);

        //TODO: save into database

        return new ProcessPaymentResult($payment);
    }
}
