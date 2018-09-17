<?php

namespace Tests\Unit;

use Tests\TestCase;
use Exception;

use Clarityboard\Client;
use Clarityboard\RecordGroup;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7;

class RecordGroupTest extends TestCase {
  public function testAllSuccess() {
    // Given
    Client::setApiKey('abc123');

    // When
    $response = RecordGroup::all()->wait();

    // Then
    $this->assertEquals($response->getStatusCode(), 200);
    $this->assertEquals(Client::getLatestRequestStats()->getEffectiveUri()->getPath(), '/v/records/groups/');
    $this->assertSame('', Client::getLatestRequestStats()->getRequest()->getBody()->getContents());
  }

  public function testUpdateWithoutGroup() {
    // Given
    $this->expectException(Exception::class);

    // When
    RecordGroup::update(['data' => []]);

    // Then
    // Exception is thrown
  }

  public function testUpdateWithoutData() {
    // Given
    $this->expectException(Exception::class);

    // When
    RecordGroup::update(['group' => 'asdf']);

    // Then
    // Exception is thrown
  }

  public function testUpdateWithoutGroupAndData() {
    // Given
    $this->expectException(Exception::class);

    // When
    RecordGroup::update([]);

    // Then
    // Exception is thrown
  }

  public function testUpdateSuccess() {
    // Given
    $groupName = 'My Group';
    $data = [
      "name" => "Shoe Laces",
      "sale" => 4.99,
      "cost" => 0.99
    ];
    $body = json_encode(['group' => $groupName, 'data' => $data]);
    Client::setApiKey('abc123');
    Client::getHandler()->setHandler(new MockHandler([
        new Response(204, ['X-Foo' => 'Bar'], Psr7\stream_for($body))
    ]));

    // When
    $response = RecordGroup::update(['group' => $groupName, 'data' => $data])->wait();

    // Then
    $this->assertEquals($response->getStatusCode(), 204);
    $this->assertEquals(Client::getLatestRequestStats()->getEffectiveUri()->getPath(), '/v/records/groups/');
    $this->assertJsonStringEqualsJsonString($body, Client::getLatestRequestStats()->getRequest()->getBody()->getContents());
  }
}
