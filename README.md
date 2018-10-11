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

Here is an example of making the call synchronously:

```php
$response = \Clarityboard\Dashboard::retrieve(['dashboardId' => 'd290f1ee-6c54-4b01-90e6-d701748f0851']);
```

### Dashboards

#### List

```php
$response = \Clarityboard\Dashboard::all();
```

#### Create

```php
\Clarityboard\Dashboard::create(['name' => 'My New Dashboard']);
```

#### Retrieve
```php
$response = \Clarityboard\Dashboard::retrieve(['dashboardId' => 'd290f1ee-6c54-4b01-90e6-d701748f0851']);
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
$response = \Clarityboard\RecordGroup::all();
```

#### Create/Update

```php
$response = RecordGroup::update(['group' => 'Sales', 'data' => ['Purchase Date' => '2018-09-17T18:24:00']]);
```

### Record

#### Create

```php
$response = Record::create([
  'group' => 'Sales', 'data' => [
    "name" => "Shoe Laces",
    "sale" => 4.99,
    "cost" => 0.99
  ]
]);
```
