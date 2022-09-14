<?php declare(strict_types = 1);

use HnutiBrontosaurus\BisClient\BisClient;


/** @var BisClient $client */
$client = require_once __DIR__ . '/bootstrap.php';

echo '<h2>Organizational units</h2>';

foreach ($client->getOrganizationalUnits() as $unit) {
	dump($unit);
}
