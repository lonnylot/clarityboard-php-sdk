<?php

namespace Clarityboard;

use Exception;
use Clarityboard\Traits\CallStaticTrait;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\TransferStats;

class Client {

  use CallStaticTrait;

  protected $baseUrl = 'https://api.clarityboard.com/v/';

  protected $key = null;

  protected $handler = null;

  protected $requestStats = [];

  protected function setApiKey($key) {
    if (!is_string($key)) {
      throw new Exception('Key must be a string.');
    }

    $this->key = $key;
  }

  protected function setBaseUrl($baseUrl) {
    if (!is_string($baseUrl)) {
      throw new Exception('Base URL must be a string.');
    }

    $this->baseUrl = $baseUrl;
  }

  protected function setHandler(callable $handler) {
    $this->handler = $handler;
  }

  protected function getHandler() {
    if (is_null($this->handler)) {
      throw new Exception('Handler must be set via '.self::class.'::setHandler()');
    }

    return $this->handler;
  }

  protected function getApiKey() {
    if (is_null($this->key)) {
      throw new Exception('Key must be set via '.self::class.'::setKey()');
    }

    return $this->key;
  }

  protected function getBaseUrl() {
    return $this->baseUrl;
  }

  protected function request($method, $endpoint, $data = null) {
    $uri = new Uri($endpoint);

    switch ($method) {
      case 'GET':
      case 'HEAD': {
        if (is_array($data)) {
          $uri = $uri->withQuery(http_build_query($data));
          $data = null;
        }
        break;
      }
      default: {
        if (is_array($data)) {
          $data = json_encode($data);
        }
      }
    }

    $clientOptions = [
      'base_uri' => $this->getBaseUrl(),
    ];

    if (!is_null($this->handler)) {
      $clientOptions['handler'] = $this->handler;
    }

    $client = new GuzzleClient($clientOptions);

    return $client->request($method, $uri, [
      'headers' => [
        'Authorization' => 'Bearer '.$this->getApiKey(),
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
        'User-Agent' => 'clarityboard-php-sdk/1.0'
      ],
      'timeout' => 10,
      'body' => $data,
      'on_stats' => [self::class, 'recordStats']
    ]);
  }

  protected function recordStats(TransferStats $stats) {
    $this->requestStats[] = $stats;
  }

  protected function getLatestRequestStats() {
    return end($this->requestStats);
  }
}
