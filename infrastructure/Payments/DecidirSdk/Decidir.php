<?php


namespace Infrastructure\Payments\DecidirSdk;


use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Monolog\Logger;

class Decidir
{
  private $client;

  const TOKENS_URL = '/api/v2/tokens';
  const PAYMENTS_URL = '/api/v2/payments';
  const STATUS_CODE_402 = 402;

  private $privateHeader = [
    'apikey' => '',
    'Content-Type' => 'application/json',
    'Cache-Control' => 'no-cache'
  ];

  /**
   * @var Logger
   */
  private $logger;

  private $siteIds = [
    'test' => [
      'private_key' => '',
      'public_key' => '',
    ],
    'prod' => [
      'private_key' => '',
      'public_key' => '',
    ],
  ];

  /**
   * Decidir constructor.
   * @param DecidirClient $client
   * @param Logger $logger
   */
  public function __construct(
    DecidirClient $client,
    Logger $logger
  ) {
    $this->client = $client;
    $this->logger = $logger;
  }

  /**
   * @param array $data
   * @param array|null $params
   * @return array
   * @throws GuzzleException
   */
  public function process(array $data, ?array $params = []): array
  {
    $this->privateHeader['apikey'] = $this->getPrivateKey();

    try {
      $response = $this->client->request('POST',self::PAYMENTS_URL, [
        'headers' => $this->privateHeader,
        'json' => $data
      ]);

      $response = [
        'status' => $response->getStatusCode(),
        'payload' => json_decode($response->getBody()->read(1024), true)
      ];

      return $response;
    } catch (RequestException $exception) {

      $response = [
        'status' => $exception->getResponse()->getStatusCode(),
        'payload' => json_decode($exception->getResponse()->getBody()->read(1024), true)
      ];
      $this->logger->error('Decidir error response: ', $response);
      return $response;
    }
  }

  public function authorize(array $data) {
    $this->privateHeader['apikey'] = $this->getPublicKey();

    try {
      $response = $this->client->request('POST',self::TOKENS_URL, [
        'headers' => $this->privateHeader,
        'json' => $data
      ]);

      $response = [
        'status' => $response->getStatusCode(),
        'payload' => json_decode($response->getBody()->read(1024), true)
      ];

      return $response;
    }catch (RequestException $exception) {
      $response = [
        'status' => $exception->getResponse()->getStatusCode(),
        'payload' => json_decode($exception->getResponse()->getBody()->read(1024), true)
      ];
      $this->logger->error('Decidir error response: ', $response);
      return $response;
    }
  }

  private function getPrivateKey()
  {
    if (env('DECIDIR_AMBIENT') === 'test') {
      $siteId = 'test';
    }
    else {
      $siteId = 'prod';
    }

    $this->logger->info('Getting private key for siteId: ' . $siteId);
    return $this->siteIds[$siteId]['private_key'];
  }

  private function getPublicKey()
  {
    if (env('DECIDIR_AMBIENT') === 'test') {
      $siteId = 'test';
    }
    else {
      $siteId = 'prod';
    }

    $this->logger->info('Getting public key for siteId: ' . $siteId);
    return $this->siteIds[$siteId]['public_key'];
  }
}
