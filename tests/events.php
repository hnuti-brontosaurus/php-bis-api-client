<?php declare(strict_types = 1);

use HnutiBrontosaurus\BisClient\BisClient;
use HnutiBrontosaurus\BisClient\Event\Category;
use HnutiBrontosaurus\BisClient\Event\Group;
use HnutiBrontosaurus\BisClient\Event\IntendedFor;
use HnutiBrontosaurus\BisClient\Event\Program;
use HnutiBrontosaurus\BisClient\Event\Request\EventParameters;


/** @var BisClient $client */
$client = require_once __DIR__ . '/bootstrap.php';


echo '<h2>Events</h2>';

$params = new EventParameters();
$params->setGroups([
	Group::CAMP(),
	Group::WEEKEND_EVENT(),
	Group::OTHER(),
]);
$params->setCategories([
	Category::EVP(),
	Category::EXPERIENTAL(),
	Category::INTERNAL(),
	Category::INTERNAL_EDUCATIONAL(),
	Category::PRESENTATION(),
	Category::PUBLIC_EDUCATIONAL(),
	Category::SECTION_EVENT(),
	Category::SECTION_MEETING(),
	Category::VOLUNTEERING(),
]);
$params->setPrograms([
	Program::NONE(),
	Program::NATURE(),
	Program::MONUMENTS(),
	Program::KIDS(),
	Program::ECO_TENT(),
	Program::HOLIDAYS_WITH_BRONTOSAURUS(),
	Program::EDUCATION(),
	Program::INTERNATIONAL(),
]);
$params->setMultipleIntendedFor([
	IntendedFor::ALL(),
	IntendedFor::YOUNG_AND_ADULT(),
	IntendedFor::KIDS(),
	IntendedFor::PARENTS_WITH_KIDS(),
	IntendedFor::FIRST_TIME_PARTICIPANT(),
]);
$events = $client->getEvents($params);
foreach ($events as $event) {
	dump($event);
}
