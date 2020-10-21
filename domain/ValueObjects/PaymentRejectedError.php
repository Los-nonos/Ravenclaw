<?php


namespace Domain\ValueObjects;


class PaymentRejectedError
{
    private $code;
    private $errorKey;
    private $message;

    /**
     * PaymentRejectedError constructor.
     * @param string $code
     * @param null|string $errorKey
     * @param null|string $message
     */
    public function __construct(string $code, ?string $errorKey, ?string $message)
    {
        $this->code = $code;
        $this->errorKey = $errorKey;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return null|string
     */
    public function getErrorKey()
    {
        return $this->errorKey;
    }

    /**
     * @return null|string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
