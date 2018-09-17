<?php

namespace Tests\Unit;

use Tests\TestCase;
use Exception;

use Clarityboard\Client;
use Clarityboard\Report;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7;

class ReportTest extends TestCase {
  public function testCreateWithoutDashboardId() {
    // Given
    $this->expectException(Exception::class);

    // When
    Report::create(['name' => 'abc123', 'chart' => 'timeline', 'rules' => []]);

    // Then
    // Exception is thrown
  }

  public function testCreateWithoutName() {
    // Given
    $this->expectException(Exception::class);

    // When
    Report::create(['dashboardId' => 'abcde-12345', 'chart' => 'timeline', 'rules' => []]);

    // Then
    // Exception is thrown
  }

  public function testCreateWithoutChart() {
    // Given
    $this->expectException(Exception::class);

    // When
    Report::create(['dashboardId' => 'abcde-12345', 'name' => 'abc123', 'rules' => []]);

    // Then
    // Exception is thrown
  }

  public function testCreateWithoutRules() {
    // Given
    $this->expectException(Exception::class);

    // When
    Report::create(['dashboardId' => 'abcde-12345', 'name' => 'abc123', 'chart' => 'timeline']);

    // Then
    // Exception is thrown
  }

  public function testCreateWithoutData() {
    // Given
    $this->expectException(Exception::class);

    // When
    Report::create([]);

    // Then
    // Exception is thrown
  }

  public function testCreateSuccess() {
    // Given
    $data = [
      'dashboardId' => 'abcde-12345',
      'name' => 'abc123',
      'chart' => 'timeline',
      'rules' => []
    ];
    $body = json_encode($data);
    Client::setKey('abc123');
    Client::getHandler()->setHandler(new MockHandler([
        new Response(201, ['X-Foo' => 'Bar'], Psr7\stream_for($body))
    ]));

    // When
    $response = Report::create($data)->wait();

    // Then
    $this->assertEquals($response->getStatusCode(), 201);
    $this->assertEquals(Client::getLatestRequestStats()->getEffectiveUri()->getPath(), '/v/reports/');
    $this->assertJsonStringEqualsJsonString($body, Client::getLatestRequestStats()->getRequest()->getBody()->getContents());
  }
}
