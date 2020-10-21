<?php


namespace Infrastructure\Payments\PaypalSdk;


use GuzzleHttp\Exception\RequestException;

class Paypal
{
  private PaypalClient $client;

  private $privateHeader = [
    'apikey' => '',
    'Content-Type' => 'application/json',
    'Cache-Control' => 'no-cache'
  ];

  const TOKENS_URL = '/api/v2/tokens';
  const PAYMENTS_URL = '/v1/payments';

  public function __construct(PaypalClient $client)
  {
    $this->client = $client;
  }

  public function process(array $data, ?array $params = [])
  {
    $this->privateHeader['apikey'] = $this->getPrivateKey();

    try {
      $url = self::PAYMENTS_URL . '?access_token=' . $this->getPrivateKey();

      $response = $this->client->request('POST', $url, [
        'headers' => $this->privateHeader,
        'json' => $data
      ]);

      $response = [
        'status' => $response->getStatusCode(),
        'payload' => json_decode($response->getBody()->read(2048), true),
      ];

      return $response;
    }catch (RequestException $exception) {

      $response = [
        'status' => $exception->getResponse()->getStatusCode(),
        'payload' => json_decode($exception->getResponse()->getBody()->read(1024), true)
      ];

      logger('MercadoPago response '. $response);

      return $response;
    }
  }

  private function getPrivateKey()
  {
    return env('PAYPAL_PRIVATE_API_KEY');
  }
}
