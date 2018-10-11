<?php

namespace Tests\Unit;

use Tests\TestCase;
use Exception;

use Clarityboard\Client;

class ClientTest extends TestCase {
  public function testSetApiRequiresString() {
    // Given
    $this->expectException(Exception::class);

    // When
    Client::setApiKey(1);

    // Then
    // Exception is thrown
  }

  public function testSetBaseUrlRequiresString() {
    // Given
    $this->expectException(Exception::class);

    // When
    Client::setBaseUrl(1);

    // Then
    // Exception is thrown
  }

  public function testGetSetKey() {
    // Given
    $key = 'abc123';

    // When
    Client::setApiKey($key);

    // Then
    $this->assertEquals(Client::getApiKey(), $key);
  }

  public function testGetSetBaseUrl() {
    // Given
    $baseUrl = 'https://fakeurl/';

    // When
    Client::setBaseUrl($baseUrl);

    // Then
    $this->assertEquals(Client::getBaseUrl(), $baseUrl);
  }
}
