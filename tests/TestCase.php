<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Clarityboard\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

abstract class TestCase extends BaseTestCase {
  protected function setUp() {
    $mock = new MockHandler([
        new Response(200, ['X-Foo' => 'Bar'])
    ]);
    $handler = HandlerStack::create($mock);
    Client::setHandler($handler);
  }

  protected function tearDown() {
    Client::reset();
  }
}
