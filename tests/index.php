<?php declare(strict_types = 1);

use HnutiBrontosaurus\BisClient\BisClient;

/** @var BisClient $client */
$client = require_once __DIR__ . '/bootstrap.php';

//$params = new \HnutiBrontosaurus\BisClient\Request\Event\EventParameters();
//$params->orderByDateFrom();
//$params->setOrganizedBy(188);
//$params->setRange(\HnutiBrontosaurus\BisClient\Request\Event\Range::FUTURE_ONLY());
//foreach ($client->getEvents($params) as $event) {
//	dump($event->getDateFrom()->format('Y-m-d') . ' — ' . $event->getDateUntil()->format('Y-m-d'));
//}
//exit;

// -----------------------------
// retrieving information test
// -----------------------------

echo '<div style="display: grid; grid-template-columns: repeat(3, 1fr)">';

	echo '<div>';
		echo '<h2>Event</h2>';
//		dump($client->getEvent(13063));
	echo '</div>';

	echo '<div style="flex-basis: 50%">';
		echo '<h2>Events</h2>';

		foreach ($client->getEvents() as $event) {
			dump($event);
		}
	echo '</div>';

	echo '<div>';
		echo '<h2>Organizational units</h2>';

		foreach ($client->getOrganizationalUnits() as $unit) {
			dump($unit);
		}
	echo '</div>';

echo '</div>';
