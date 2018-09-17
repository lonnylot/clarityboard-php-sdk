<?php

namespace Clarityboard;

use Clarityboard\Traits\CallStaticTrait;

use Exception;

class Dashboard {

  use CallStaticTrait;

  protected $baseEndpoint = 'dashboards/';

  protected function create($data) {
    if (!isset($data['name']) || !is_string($data['name'])) {
      throw new Exception('"name" is required. Please refer to the API documentation.');
    }

    return Client::request('POST', $this->baseEndpoint, $data);
  }

  protected function retrieve($data) {
    if (!isset($data['dashboardId']) || !is_string($data['dashboardId'])) {
      throw new Exception('"dashboardId" is required. Please refer to the API documentation.');
    }

    return Client::request('GET', $this->baseEndpoint, $data);
  }
}
