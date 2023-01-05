<?php declare(strict_types = 1);

use HnutiBrontosaurus\BisClient\BisClient;
use HnutiBrontosaurus\BisClient\Request\Event\EventParameters;


/** @var BisClient $client */
$client = require_once __DIR__ . '/bootstrap.php';


echo '<h2>Events</h2>';

$params = new EventParameters();
$events = $client->getEvents($params);
foreach ($events as $event) {
	dump($event);
}
