<?php declare(strict_types = 1);

use HnutiBrontosaurus\BisClient\BisClient;
use HnutiBrontosaurus\BisClient\Request\Event\EventAttendee;

/** @var BisClient $client */
$client = require_once __DIR__ . '/bootstrap.php';


$addAttendee = static fn(int $eventId) =>
	$client->addAttendee(new EventAttendee(
		$eventId,
		'Jan',
		'Novák',
		DateTimeImmutable::createFromFormat('Y-m-d', '2000-05-01'),
		'123 456 789',
		'jan.novak@example.com',
		'prosím, abych tam měl nachystanou teplou peřinu',
		['odpověď č. 1', '', 'odpověď č. 3'],
	));

/*
 * Uncomment line below to run a test.
 * ⚠ Don't forget to change event ID not to pollute real events with testing data!
 */
//$addAttendee(eventId: 13703);
