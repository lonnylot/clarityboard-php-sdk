<?php

namespace Tests\Unit;

use Tests\TestCase;
use Exception;

use Clarityboard\Client;
use Clarityboard\Dashboard;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7;

class DashboardTest extends TestCase {
  public function testAllSuccess() {
    // Given
    Client::setApiKey('abc123');

    // When
    $response = Dashboard::all()->wait();

    // Then
    $this->assertEquals($response->getStatusCode(), 200);
    $this->assertEquals(Client::getLatestRequestStats()->getEffectiveUri()->getPath(), '/v/dashboards/');
    $this->assertSame('', Client::getLatestRequestStats()->getRequest()->getBody()->getContents());
  }

  public function testCreateWithoutName() {
    // Given
    $this->expectException(Exception::class);

    // When
    Dashboard::create([]);

    // Then
    // Exception is thrown
  }

  public function testCreateSuccess() {
    // Given
    $dashboardName = 'My Dashboard';
    $body = json_encode(['name' => $dashboardName]);
    Client::setApiKey('abc123');
    Client::getHandler()->setHandler(new MockHandler([
        new Response(201, ['X-Foo' => 'Bar'], Psr7\stream_for($body))
    ]));

    // When
    $response = Dashboard::create(['name' => $dashboardName])->wait();

    // Then
    $this->assertEquals($response->getStatusCode(), 201);
    $this->assertEquals(Client::getLatestRequestStats()->getEffectiveUri()->getPath(), '/v/dashboards/');
    $this->assertJsonStringEqualsJsonString($body, Client::getLatestRequestStats()->getRequest()->getBody()->getContents());
  }

  public function testRetrieveWithoutDashboardId() {
    // Given
    $this->expectException(Exception::class);

    // When
    Dashboard::retrieve([]);

    // Then
    // Exception is thrown
  }

  public function testRetrieveSuccess() {
    // Given
    $dashboardId = '12345-abcde';
    $body = json_encode(['dashboardId' => $dashboardId]);
    Client::setApiKey('abc123');

    // When
    $response = Dashboard::retrieve(['dashboardId' => $dashboardId])->wait();

    // Then
    $this->assertEquals($response->getStatusCode(), 200);
    $this->assertEquals(Client::getLatestRequestStats()->getEffectiveUri()->getPath(), '/v/dashboards/');
    $this->assertContains($dashboardId, Client::getLatestRequestStats()->getEffectiveUri()->getQuery());
  }

  public function testRetrieveCanUseGranularityId() {
    // Given
    $dashboardId = '12345-abcde';
    $granularityId = 'weekly';
    Client::setApiKey('abc123');

    // When
    $response = Dashboard::retrieve(['dashboardId' => $dashboardId, 'granularityId' => $granularityId])->wait();

    // Then
    $this->assertContains($granularityId, Client::getLatestRequestStats()->getEffectiveUri()->getQuery());
  }

  public function testRetrieveCanUseTimeframeId() {
    // Given
    $dashboardId = '12345-abcde';
    $timeframeId = 'four-weeks';
    Client::setApiKey('abc123');

    // When
    $response = Dashboard::retrieve(['dashboardId' => $dashboardId, 'timeframeId' => $timeframeId])->wait();

    // Then
    $this->assertContains($timeframeId, Client::getLatestRequestStats()->getEffectiveUri()->getQuery());
  }
}
