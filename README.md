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

Create client instance with the only parameter – BIS API URL:

```php
use HnutiBrontosaurus\BisClient\BisClientFactory;

$bisClientFactory = new BisClientFactory('https://bis.brontosaurus.cz/api');
$bisClient = $bisClientFactory->create();
```

Instance of `\HnutiBrontosaurus\BisClient\BisClient` is returned which is your toolset to retrieve any information from BIS.

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
$parameters = new \HnutiBrontosaurus\BisClient\Event\Request\EventParameters();
$events = $client->getEvents($parameters); // $parameters are optional

// example of reading data
foreach ($events as $event) {
    $event->getName();
}
```

#### Filters

Events can be filtered by group, category, program or intended for:

```php
$parameters = new \HnutiBrontosaurus\BisClient\Event\Request\EventParameters();

// only camps
$parameters->setGroup(\HnutiBrontosaurus\BisClient\Event\Group::CAMP());

// only events of "voluntary" category
$parameters->setCategory(\HnutiBrontosaurus\BisClient\Event\Category::VOLUNTEERING());

// only events of "PsB" program
$parameters->setProgram(\HnutiBrontosaurus\BisClient\Event\Program::HOLIDAYS_WITH_BRONTOSAURUS());

// only events intended for first time participants
$parameters->setIntendedFor(\HnutiBrontosaurus\BisClient\Event\IntendedFor::FIRST_TIME_PARTICIPANT());

// only for some administration units
$parameters->setAdministrationUnit(5);

$events = $client->getEvents($parameters);
```

Note that each method call rewrites the previous one:

```php
$parameters->setCategory(\HnutiBrontosaurus\BisClient\Event\Category::VOLUNTEERING());
$parameters->setCategory(\HnutiBrontosaurus\BisClient\Event\Category::EXPERIENCE());
// ⚠ result is only "EXPERIENCE"
```

You can set more values at once with method's plural complement:

```php
$parameters = new \HnutiBrontosaurus\BisClient\Event\Request\EventParameters();

$parameters->setCategories([
    \HnutiBrontosaurus\BisClient\Event\Category::VOLUNTEERING(),
    \HnutiBrontosaurus\BisClient\Event\Category::EXPERIENCE(),
]);

$events = $client->getEvents($parameters);
```

#### Period

Restrict retrieved events to be in given period:

```php
$parameters = new \HnutiBrontosaurus\BisClient\Event\Request\EventParameters();

$parameters->setPeriod(\HnutiBrontosaurus\BisClient\Event\Request\Period::RUNNING_AND_FUTURE()); // default
$parameters->setPeriod(\HnutiBrontosaurus\BisClient\Event\Request\Period::RUNNING_ONLY());
$parameters->setPeriod(\HnutiBrontosaurus\BisClient\Event\Request\Period::UNLIMITED());

$events = $client->getEvents($parameters);
```

> ⚠ Note that setting `PAST_ONLY`, `RUNNING_AND_PAST` or `UNLIMITED` retrieves thousands of events. It's good idea to narrow the amount with `->setLimit()` (see below)

For convenience, you can also set date start and/or end on low level:

```php
$date = \Brick\DateTime\LocalDate::parse('2022-01-01');
$parameters->setDateStartLessThanOrEqualTo($date);
$parameters->setDateStartGreaterThanOrEqualTo($date);
$parameters->setDateEndLessThanOrEqualTo($date);
$parameters->setDateEndGreaterThanOrEqualTo($date);
```

If you need to reset default/previous dates:

```php
// either
$date = \Brick\DateTime\LocalDate::parse('2022-01-01');
$parameters->resetDates();
$parameters->setDateStartLessThanOrEqualTo($date);

// or
$date = \Brick\DateTime\LocalDate::parse('2022-01-01');
$parameters->setDateStartLessThanOrEqualTo($date, reset: true);
```

> Note that semantic value objects from [`brick/date-time`](https://github.com/brick/date-time) are used instead of native `DateTime(Immutable)` class. More on why at [this blogpost](https://jiripudil.cz/blog/beyond-datetime-domain-driven-approach).

#### Ordering

Choose whether you want to order by start or end date:

```php
$parameters = new \HnutiBrontosaurus\BisClient\Event\Request\EventParameters();

// sort events by date from or date to
$parameters->orderByStartDate();
$parameters->orderByEndDate(); // default

$events = $client->getEvents($parameters);
```

Both methods have optional parameter `$desc` which allows to sort events in DESC order:

```php
$parameters->orderByDateFrom(desc: true);
```

#### Limit

Limit the size of obtained events or remove the limit completely:

```php
$parameters = new \HnutiBrontosaurus\BisClient\Event\Request\EventParameters();

$parameters->setLimit(50);
$parameters->removeLimit();

$events = $client->getEvents($parameters);
```


## Administration units

For retrieving information about all administration units:

```php
$parameters = new \HnutiBrontosaurus\BisClient\AdministrationUnit\Request\AdministrationUnitParameters();
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
$parameters = new \HnutiBrontosaurus\BisClient\Opportunity\Request\OpportunityParameters();
$opportunities = $client->getOpportunities($parameters); // $parameters is optional

foreach ($opportunities as $opportunity) {
    $opportunity->getName();
    $opportunity->getStartDate();
    $opportunity->getIntroduction();
    $opportunity->getLocation()->getCoordinates();
}
```

Or only single one:

```php
$opportunity = $client->getOpportunity(1234);

$opportunity->getName();
$opportunity->getStartDate();
$opportunity->getIntroduction();
$opportunity->getLocation()->getCoordinates();
```


## Exceptions

Client provides few exceptions to handle errors in communication with BIS.

### Generic

`ConnectionToBisFailed` is the most generic one and it covers all kind of problems in the communication.

```php
try {
    $events = $bisClient->getEvents();

} catch (\HnutiBrontosaurus\BisClient\ConnectionToBisFailed) {
    // render something like "BIS is currently unavailable, please try again later or contact us at..."
}
```

### Not found

Every method which requests single resource throws also `*NotFound` exception in case the resource was not found. For event, it's `EventNotFound`:

```php
try {
    $event = $bisClient->getEvent(123);

} catch (\HnutiBrontosaurus\BisClient\EventNotFound) {
    // render some 404 page

} catch (\HnutiBrontosaurus\BisClient\ConnectionToBisFailed) {
    // render something like "BIS is currently unavailable, please try again later or contact us at..."
}
```



## Debug information

On `\HnutiBrontosaurus\BisClient\BisClient`, there are two debug methods:

- `getLastRequestUrl()` – returns URL of last request; note that as HTTP client is internally call endpoint multiple times to avoid pagination, only the very last requested URL is returned
- `getLastResponse()` – returns either parsed array or JSON string with last response


# Development

## Installation

```
composer install
```

## Structure

- `docs` – instruction on how connection between brontoweb and BIS works (todo: move to brontoweb repo)
- `src` – source code
    - `AdministrationUnit` – value objects related to administration units
    - `Event` – value objects related to events
    - `Opportunity` – value objects related to opportunities
    - `Response` – response value objects common to all endpoints
    - `BisClient` – client itself, serves for making requests to BIS API
    - `BisClientFactory` – takes configuration and creates instance of `BisClient`
    - `HttpClient` – wrapper around Guzzle client which adds BIS API specific pieces into the request
- `tests` – test code

**Note that this library bundles Guzzle HTTP client as we can not rely on having composer in user's codebase.**

## Tests

This library has just visual tests, no automated. 
Run `tests/index.php` on a local webserver and check if results are rendered or an error occurs.

Note that you need to copy `tests/config.template.php` to `tests/config.php` and update it first.
