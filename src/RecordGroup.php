<?php

namespace Clarityboard;

use Clarityboard\Traits\CallStaticTrait;

use Exception;

class RecordGroup {

  use CallStaticTrait;

  protected $baseEndpoint = 'records/groups/';

  protected function all() {
    return Client::request('GET', $this->baseEndpoint);
  }

  protected function update($data) {
    if (!isset($data['group']) || !is_string($data['group'])) {
      throw new Exception('"group" is required. Please refer to the API documentation.');
    }

    if (!isset($data['data']) || !is_array($data['data'])) {
      throw new Exception('"data" is required. Please refer to the API documentation.');
    }

    return Client::request('PUT', $this->baseEndpoint, $data);
  }
}
