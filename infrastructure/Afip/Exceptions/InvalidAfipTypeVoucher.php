<?php


namespace Infrastructure\Afip\Exceptions;


use App\Exceptions\ApplicationException;
use Presentation\Http\Enums\HttpCodes;
use Throwable;

class InvalidAfipTypeVoucher extends ApplicationException
{

    /**
     * InvalidAfipTypeVoucher constructor.
     */
    public function __construct($message = "Invalid Afip type voucher, not found")
    {
        parent::__construct($message, HttpCodes::UNPROCESSABLE_ENTITY);
    }
}
