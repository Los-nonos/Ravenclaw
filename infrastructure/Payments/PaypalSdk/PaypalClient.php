<?php


namespace Infrastructure\Payments\PaypalSdk;


use GuzzleHttp\Client;

class PaypalClient extends Client
{
  public function __construct()
  {
    parent::__construct(['base_uri' => env('PAYPAL_PATH')]);
  }
}
