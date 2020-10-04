<?php


namespace Application\Commands\Handler\Payments;


use Application\Commands\Command\Payments\ProcessPaymentsCommand;
use Application\Exceptions\InvalidPayment;
use Application\Services\Customer\CustomerServiceInterface;
use Application\Services\Payer\PayerService;
use Application\Services\Payments\PaymentService;
use DateTimeImmutable;
use Domain\Enums\PaymentState;
use Infrastructure\Payments\Exceptions\GatewayNotFound;
use Infrastructure\Payments\Exceptions\PaymentRejectedException;
use Infrastructure\Payments\Factories\PaymentGatewayFactory;
use Infrastructure\Payments\ValueObjects\PaymentParams;
use Infrastructure\CommandBus\Handler\HandlerInterface;
use Money\Currency;
use Money\Money;
use Money\UnknownCurrencyException;

class ProcessPaymentsHandler implements HandlerInterface
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
   * @param ProcessPaymentsCommand $command
   * @throws InvalidPayment|GatewayNotFound|UnknownCurrencyException|PaymentRejectedException
   */
  public function handle($command): void
  {
    $amount = new Money($command->getAmount(), new Currency($command->getCurrency()));

    $customer = $this->customerService->findCustomerByIdOrFail($command->getCustomerId());

    $payer = $this->payerService->findOrCreate($command->getPayerName(), $command->getPayerDni(), $command->getPayerEmail());

    $payment = $this->paymentService->create($amount, $customer, $payer, $command->getGatewayId() ?? self::DEFAULT_GATEWAY);

    $params = [
      self::KEY_TOKEN => $command->getToken(),
      self::KEY_CREDIT_BIN => $command->getBin(),
      self::KEY_INSTALLMENT => 10,
      self::KEY_PAYMENT_METHOD_ID => $command->getPaymentMethod()
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
  }
}
