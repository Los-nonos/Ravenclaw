<?php


namespace Application\Queries\Handler\Payments;


use Application\Queries\Query\Payments\AuthorizePaymentsQuery;
use Application\Queries\Results\Payments\AuthorizePaymentsResult;
use Infrastructure\Payments\Factories\PaymentGatewayFactory;
use Infrastructure\Payments\ValueObjects\PaymentParams;
use Infrastructure\QueryBus\Handler\HandlerInterface;
use Infrastructure\QueryBus\Result\ResultInterface;

class AuthorizePaymentsHandler implements HandlerInterface
{
  const DEFAULT_GATEWAY = 'decidir';

  private PaymentGatewayFactory $gatewayFactory;

  public function __construct(PaymentGatewayFactory $gatewayFactory)
  {
    $this->gatewayFactory = $gatewayFactory;
  }

  /**
   * @param AuthorizePaymentsQuery $query
   * @return ResultInterface
   */
  public function handle($query): ResultInterface
  {
    $params = [
      'name' => $query->getName(),
      'bin' => $query->getCardNumber(),
      'secure_code' => $query->getSecurityCode(),
      'expiration_month' => $query->getExpirationMonth(),
      'expiration_year' => $query->getExpirationYear(),
      'identification' => $query->getIdentification(),
    ];

    $paymentParams = new PaymentParams($params);

    $gateway = $this->gatewayFactory->create($query->getGateway() ?? self::DEFAULT_GATEWAY);

    $data = $gateway->authorize($paymentParams);

    return new AuthorizePaymentsResult($data);
  }
}
