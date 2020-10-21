<?php


namespace Infrastructure\Payments\DecidirSdk;


use GuzzleHttp\Client;

class DecidirClient extends Client
{
  public function __construct()
  {
    parent::__construct(['base_uri' => env('DECIDIR_PATH')]);
  }
}
