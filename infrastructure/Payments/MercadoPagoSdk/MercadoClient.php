<?php


namespace Infrastructure\Payments\MercadoPagoSdk;


use GuzzleHttp\Client;

class MercadoClient extends Client
{
    public function __construct()
    {
        parent::__construct(['base_uri' => env('MERCADO_PAGO_PATH')]);
    }
}
