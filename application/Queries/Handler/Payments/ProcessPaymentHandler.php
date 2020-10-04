<?php


namespace Application\Queries\Handler\Payments;


use Application\Exceptions\InvalidPayment;
use Application\Queries\Query\Payments\ProcessPaymentQuery;
use Application\Queries\Results\Payments\ProcessPaymentResult;
use Application\Services\Customer\CustomerServiceInterface;
use Application\Services\Payer\PayerService;
use Application\Services\Payments\PaymentService;
use DateTimeImmutable;
use Domain\Enums\PaymentState;
use Infrastructure\Payments\Exceptions\GatewayNotFound;
use Infrastructure\Payments\Exceptions\PaymentRejectedException;
use Infrastructure\Payments\Factories\PaymentGatewayFactory;
use Infrastructure\Payments\ValueObjects\PaymentParams;
use Infrastructure\QueryBus\Handler\HandlerInterface;
use Infrastructure\QueryBus\Query\QueryInterface;
use Infrastructure\QueryBus\Result\ResultInterface;
use Money\Currency;
use Money\Money;
use Money\UnknownCurrencyException;

class ProcessPaymentHandler implements HandlerInterface
{
  const DEFAULT_GATEWAY = 'decidir';
  const KEY_TOKEN = 'token';
  const KEY_CREDIT_BIN = 'bin';
  const KEY_INSTALLMENT = 'installments';
  const KEY_PAYMENT_METHOD_ID = 'payment_method';


  private PaymentGatewayFactory $paymentGatewayFactory;
  private PaymentService $paymentService;
  private CustomerServiceInterface $customerService;
  private PayerService $payerService;

  public function __construct(
    PaymentGatewayFactory $paymentGatewayFactory,
    PaymentService $paymentService,
    CustomerServiceInterface $customerService,
    PayerService $payerService
  ){
    $this->paymentGatewayFactory = $paymentGatewayFactory;
    $this->paymentService = $paymentService;
    $this->customerService = $customerService;
    $this->payerService = $payerService;
  }

  /**
   * @param ProcessPaymentQuery $query
   * @return ResultInterface
   * @throws InvalidPayment|GatewayNotFound|UnknownCurrencyException|PaymentRejectedException
   */
  public function handle($query): ResultInterface
  {
    $amount = new Money($query->getAmount(), new Currency($query->getCurrency()));

    $customer = $this->customerService->findCustomerByIdOrFail($query->getCustomerId());

    $payer = $this->payerService->findOrCreate($query->getPayerName(), $query->getPayerDni(), $query->getPayerEmail());

    $payment = $this->paymentService->create($amount, $customer, $payer, $query->getGatewayId() ?? self::DEFAULT_GATEWAY);

    $params = [
      self::KEY_TOKEN => $query->getToken(),
      self::KEY_CREDIT_BIN => $query->getBin(),
      self::KEY_INSTALLMENT => 10,
      self::KEY_PAYMENT_METHOD_ID => $query->getPaymentMethod()
    ];

    $paymentParams = new PaymentParams($params);

    logger('Payment params ' . print_r($payment->getParam('payment_gateway')));

    $gateway = $this->paymentGatewayFactory->create($payment->getGateway());

    $payment = $gateway->prepare($payment, $paymentParams);
    $payment = $gateway->process($payment);

    if ($gateway->currentState($payment) === PaymentState::AUTHORIZED) {
      $payment->setPaidDate(new DateTimeImmutable());
      $payment->setState(PaymentState::AUTHORIZED);

      $this->paymentService->save($payment);

    }else if($gateway->currentState($payment) === PaymentState::REJECT) {
      $payment->setPaidDate(new DateTimeImmutable());
      $payment->setState(PaymentState::REJECT);

      $this->paymentService->save($payment);

      throw new PaymentRejectedException('Pago rechazado, por favor revise los datos ingresados o intente más tarde');
    }

    return new ProcessPaymentResult($payment);
  }
}
