<?php


namespace Application\Queries\Results\Payments;


use Infrastructure\QueryBus\Result\ResultInterface;

class AuthorizePaymentsResult implements ResultInterface
{
  private array $data;

  public function __construct(
    $data
  ) {
    $this->data = $data;
  }

  public function getData() {
    return $this->data;
  }
}
