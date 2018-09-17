<?php

namespace Tests\Unit;

use Tests\TestCase;
use Exception;

use Clarityboard\Client;
use Clarityboard\Record;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7;

class RecordTest extends TestCase {
  public function testCreateWithoutGroup() {
    // Given
    $this->expectException(Exception::class);

    // When
    Record::create(['data' => []]);

    // Then
    // Exception is thrown
  }

  public function testCreateWithoutData() {
    // Given
    $this->expectException(Exception::class);

    // When
    Record::create(['group' => 'asdf']);

    // Then
    // Exception is thrown
  }

  public function testCreateWithoutGroupAndData() {
    // Given
    $this->expectException(Exception::class);

    // When
    Record::create([]);

    // Then
    // Exception is thrown
  }

  public function testCreateSuccess() {
    // Given
    $groupName = 'My Group';
    $data = [
      "name" => "Shoe Laces",
      "sale" => 4.99,
      "cost" => 0.99
    ];
    $body = json_encode(['group' => $groupName, 'data' => $data]);
    Client::setKey('abc123');
    Client::getHandler()->setHandler(new MockHandler([
        new Response(204, ['X-Foo' => 'Bar'], Psr7\stream_for($body))
    ]));

    // When
    $response = Record::create(['group' => $groupName, 'data' => $data])->wait();

    // Then
    $this->assertEquals($response->getStatusCode(), 204);
    $this->assertEquals(Client::getLatestRequestStats()->getEffectiveUri()->getPath(), '/v/records/');
    $this->assertJsonStringEqualsJsonString($body, Client::getLatestRequestStats()->getRequest()->getBody()->getContents());
  }
}
