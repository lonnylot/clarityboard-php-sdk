<?php

namespace Clarityboard;

use Clarityboard\Traits\CallStaticTrait;

use Exception;

class Report {

  use CallStaticTrait;

  protected $baseEndpoint = 'reports/';

  protected function create($data) {
    if (!isset($data['dashboardId']) || !is_string($data['dashboardId'])) {
      throw new Exception('"dashboardId" is required. Please refer to the API documentation.');
    }

    if (!isset($data['name']) || !is_string($data['name'])) {
      throw new Exception('"name" is required. Please refer to the API documentation.');
    }

    if (!isset($data['chart']) || !is_string($data['chart'])) {
      throw new Exception('"chart" is required. Please refer to the API documentation.');
    }

    if (!isset($data['rules']) || !is_array($data['rules'])) {
      throw new Exception('"rules" is required. Please refer to the API documentation.');
    }

    return Client::request('POST', $this->baseEndpoint, $data);
  }
}
