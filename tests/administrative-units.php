<?php declare(strict_types = 1);

use HnutiBrontosaurus\BisClient\BisClient;
use HnutiBrontosaurus\BisClient\Request\AdministrationUnit\AdministrationUnitParameters;


/** @var BisClient $client */
$client = require_once __DIR__ . '/bootstrap.php';

echo '<h2>Organizational units</h2>';

$params = new AdministrationUnitParameters();
$units = $client->getAdministrationUnits($params);
foreach ($units as $unit) {
	dump($unit);
}
