<?php

namespace Clarityboard;

use Clarityboard\Traits\CallStaticTrait;

use Exception;

class Record {

  use CallStaticTrait;

  protected $baseEndpoint = 'records/';

  protected function create($data) {
    if (!isset($data['group']) || !is_string($data['group'])) {
      throw new Exception('"group" is required. Please refer to the API documentation.');
    }

    if (!isset($data['data']) || !is_array($data['data'])) {
      throw new Exception('"data" is required. Please refer to the API documentation.');
    }

    return Client::request('POST', $this->baseEndpoint, $data);
  }
}
