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
    Client::setKey(1);

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
    Client::setKey($key);

    // Then
    $this->assertEquals(Client::getKey(), $key);
  }

  public function testGetSetBaseUrl() {
    // Given
    $baseUrl = 'https://fakeurl/';

    // When
    Client::setBaseUrl($baseUrl);

    // Then
    $this->assertEquals(Client::getBaseUrl(), $baseUrl);
  }

  public function testMockRequest() {
    // Given
    Client::setKey('abc123');

    // When
    $response = Client::request('GET', '/dashboard');

    // Then
    $this->assertEquals($response->getStatusCode(), 200);
  }
}
