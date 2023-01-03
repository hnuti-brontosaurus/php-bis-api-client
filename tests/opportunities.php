<?php declare(strict_types = 1);

use HnutiBrontosaurus\BisClient\BisClient;
use HnutiBrontosaurus\BisClient\Enums\OpportunityCategory;
use HnutiBrontosaurus\BisClient\Request\Opportunity\OpportunityParameters;


/** @var BisClient $client */
$client = require_once __DIR__ . '/bootstrap.php';

echo '<h2>Opportunities</h2>';

$params = new OpportunityParameters();
//$params->setCategory(OpportunityCategory::ORGANIZING());
foreach ($client->getOpportunities($params) as $event) {
	dump($event);
}
