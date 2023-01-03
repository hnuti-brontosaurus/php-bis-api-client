This library allows you to easily communicate with BIS API.

# Installation

## Composer

Add path to `repositories`:

```
{
	"url": "https://github.com/hnuti-brontosaurus/php-bis-api-client.git",
	"type": "vcs"
}
```

and install package:
```
composer require hnuti-brontosaurus/php-bis-api-client
```

## Manually

Download latest version from [github](https://github.com/hnuti-brontosaurus/php-bis-api-client/releases) to your computer.


# Usage

First you need to create client instance. The only parameter to pass is an API URL.

```php
$client = (new BisClientFactory('apiUrl'))
    ->create();
```

Now you can perform any of available operations.

## Events

### Single event

Retrieve all information about single event:

```php
$event = $client->getEvent($id);

// examples of reading data
$event->getName();
$event->getOrganizer()->getResponsiblePerson();
$event->getRegistrationType()->isOfTypeCustomWebpage();
$event->getLocation()->getCoordinates();
```

### More events

Retrieve all information about multiple events.

Basic usage:

```php
$parameters = new \HnutiBrontosaurus\BisClient\Request\Event\EventParameters();
$events = $client->getEvents($parameters); // $parameters are optional

// example of reading data
foreach ($events as $event) {
    $event->getName();
}
```

#### Filters

You can filter in many ways:

```php
$parameters = new \HnutiBrontosaurus\BisClient\Request\Event\EventParameters();

// only camps
$parameters->setGroup(\HnutiBrontosaurus\BisClient\Enums\EventGroup::CAMP());

// only events of "voluntary" category
$parameters->setCategory(\HnutiBrontosaurus\BisClient\Enums\EventCategory::VOLUNTARY());

// only events of "PsB" program
$parameters->setProgram(\HnutiBrontosaurus\BisClient\Enums\Program::PSB());

// only events intended for first time participants
$parameters->setTargetGroup(\HnutiBrontosaurus\BisClient\Enums\IntendedFor::FIRST_TIME_PARTICIPANT());

$events = $client->getEvents($parameters);
```

For group, category, program and intended for, you can set more values at once like so:

```php
$parameters = new \HnutiBrontosaurus\BisClient\Request\Event\EventParameters();

$parameters->setCategories([
    \HnutiBrontosaurus\BisClient\Enums\EventCategory::VOLUNTARY(),
    \HnutiBrontosaurus\BisClient\Enums\EventCategory::SPORT(),
]);

$events = $client->getEvents($parameters);
```

Note that each method call rewrites the previous one:

```php
$parameters = new \HnutiBrontosaurus\BisClient\Request\Event\EventParameters();

// sets "voluntary" category
$parameters->setCategory(\HnutiBrontosaurus\BisClient\Enums\EventCategory::VOLUNTARY());
// rewrites category to "sport"
$parameters->setCategory(\HnutiBrontosaurus\BisClient\Enums\EventCategory::SPORT());

$events = $client->getEvents($parameters);
```

#### Sorting

You can use some basic sorting options:

```php
$parameters = new \HnutiBrontosaurus\BisClient\Request\Event\EventParameters();

// sort events by date from or date to
$parameters->orderByDateFrom();
$parameters->orderByDateTo(); // default

$events = $client->getEvents($parameters);
```

## Administration units

For retrieving information about all administration units:

```php
$parameters = new \HnutiBrontosaurus\BisClient\Request\AdministrationUnit\AdministrationUnitParameters();
$administrationUnits = $client->getAdministrationUnits($parameters); // $parameters is optional

foreach ($administrationUnits as $administrationUnit) {
    $administrationUnit->getName();
    $administrationUnit->getCity();
    $administrationUnit->getChairman();
    $administrationUnit->getCoordinates();
}
```

## Opportunities

Retrieving information about all opportunities:

```php
$parameters = new \HnutiBrontosaurus\BisClient\Request\Opportunity\OpportunityParameters();
$opportunities = $client->getOpportunities($parameters); // $parameters is optional

foreach ($opportunities as $opportunity) {
    $opportunity->getName();
    $opportunity->getDateStart();
    $opportunity->getIntroduction();
    $opportunity->getLocation()->getCoordinates();
}
```

Or only single one:

```php
$opportunity = $client->getOpportunity(1234);

$opportunity->getName();
$opportunity->getDateStart();
$opportunity->getIntroduction();
$opportunity->getLocation()->getCoordinates();
```


# Development

## Installation

```
composer install
```

## Structure

- `docs` – instruction on how connection between brontoweb and BIS works (todo: move to brontoweb repo)
- `src` – source code
    - `Enums` – basic enum types
    - `Request` – request-related value objects
    - `Response` – response-related value objects and exceptions
    - `BisClient` – client itself, serves for making requests to BIS API
    - `BisClientFactory` – takes configuration and creates instance of `BisClient`
    - `HttpClient` – wrapper around Guzzle client which adds BIS API specific pieces into the request
- `tests` – test code

**Note that this library bundles Guzzle HTTP client as we can not rely on having composer in user's codebase.**

## Tests

This library has just `tests/index.php` which – if run on a webserver – will
pass or fail visually – no error and results output or an exception.

You need to copy `tests/config.template.php` to `tests/config.php` to be able to run it.
