# Introduction
This is the [Clarityboard](https://www.clarityboard.com) SDK for PHP. Please refer to our [API Docs](https://clarityboard.docs.apiary.io/#) for more information.

## Requirements
PHP 5.4.0 and later.

## Composer

You can install the bindings via Composer. Run the following command:

`composer require lonnylot/clarityboard-php-sdk`

To use the bindings, use Composer's autoload:

`require_once('vendor/autoload.php');`

## Dependencies

The library requires the [GuzzleHTTP](http://docs.guzzlephp.org/en/stable/) library.

## Getting Started

Before using the SDK endpoints you _must_ set your API key:

```php
\Clarityboard\Client::setApiKey('enter-your-api-key');
```

All requests are made asynchronysly with the [Guzzle Promises](https://github.com/guzzle/promises) API. The library uses the [Promises/A+ Spec](https://promisesaplus.com/).

Here is an example of resolving a promise:

```php
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;

$promise = \Clarityboard\Dashboard::retrieve(['dashboardId' => 'd290f1ee-6c54-4b01-90e6-d701748f0851']);
$promise->then(
    function (ResponseInterface $res) {
        echo $res->getStatusCode() . "\n";
    },
    function (RequestException $e) {
        echo $e->getMessage() . "\n";
        echo $e->getRequest()->getMethod();
    }
);
```

Alternatively, you can use the `wait()` function to do the request synchronously.

Here is an example of making the call synchronously:

```php
$response = \Clarityboard\Dashboard::retrieve(['dashboardId' => 'd290f1ee-6c54-4b01-90e6-d701748f0851'])->wait();
```

### Dashboards

#### List

```php
$response = \Clarityboard\Dashboard::all()->wait();
```

#### Create

```php
\Clarityboard\Dashboard::create(['name' => 'My New Dashboard']);
```

#### Retrieve
```php
$response = \Clarityboard\Dashboard::retrieve(['dashboardId' => 'd290f1ee-6c54-4b01-90e6-d701748f0851'])->wait();
```

### Records

#### Create

```php
\Clarityboard\Dashboard::create([
  'group' => 'Sales',
  'data' => [
    "name" => "Shoe Laces",
    "sale" => 4.99,
    "cost" => 0.99
  ]
]);
```

### Record Group

#### List

```php
$response = \Clarityboard\RecordGroup::all()->wait();
```

#### Create/Update

```php
$response = RecordGroup::update(['group' => 'Sales', 'data' => ['Purchase Date' => '2018-09-17T18:24:00']])->wait();
```

### Record

#### Create

```php
$promise = Record::create([
  'group' => 'Sales', 'data' => [
    "name" => "Shoe Laces",
    "sale" => 4.99,
    "cost" => 0.99
  ]
]);

$promise->then(
  function (ResponseInterface $res) {
      echo $res->getStatusCode() . "\n";
      var_dump(Client::getLatestRequestStats()->getRequest()->getBody()->getContents());
  },
  function (RequestException $e) {
      echo $e->getMessage() . "\n";
      echo $e->getRequest()->getMethod();
  }
);
```
