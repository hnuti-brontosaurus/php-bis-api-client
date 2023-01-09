<?php declare(strict_types = 1);

use HnutiBrontosaurus\BisClient\AdministrationUnit\Category;
use HnutiBrontosaurus\BisClient\AdministrationUnit\Request\AdministrationUnitParameters;
use HnutiBrontosaurus\BisClient\BisClient;


/** @var BisClient $client */
$client = require_once __DIR__ . '/bootstrap.php';

echo '<h2>Administration units</h2>';

$params = new AdministrationUnitParameters();
$params->setCategories([
	Category::CLUB(),
	Category::BASIC_SECTION(),
	Category::REGIONAL_CENTER(),
	Category::HEADQUARTER(),
]);
$units = $client->getAdministrationUnits($params);
foreach ($units as $unit) {
	dump($unit);
}
