<?php


namespace Infrastructure\Payments\Exceptions;


use App\Exceptions\ApplicationException;
use Domain\ValueObjects\PaymentRejectedError;

class PaymentRejectedException extends ApplicationException
{
    private PaymentRejectedError $error;

    public function setError(PaymentRejectedError $error)
    {
      $this->message = $error->getMessage() . ' ' . $error->getErrorKey();

      $this->error = $error;
    }
}
