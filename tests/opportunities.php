<?php declare(strict_types = 1);

use HnutiBrontosaurus\BisClient\BisClient;
use HnutiBrontosaurus\BisClient\Opportunity\Category;
use HnutiBrontosaurus\BisClient\Opportunity\Request\OpportunityParameters;


/** @var BisClient $client */
$client = require_once __DIR__ . '/bootstrap.php';

echo '<h2>Opportunities</h2>';

$params = new OpportunityParameters();
$params->setCategories([
	Category::ORGANIZING(),
	Category::COLLABORATION(),
	Category::LOCATION_HELP(),
]);
$opportunities = $client->getOpportunities($params);
foreach ($opportunities as $opportunity) {
	dump($opportunity);
}
