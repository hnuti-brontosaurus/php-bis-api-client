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
	Category::VOLUNTEERING(),
	Category::EXPERIENCE(),
	Category::EDUCATIONAL_LECTURE(),
	Category::EDUCATIONAL_COURSE(),
	Category::EDUCATIONAL_OHB(),
	Category::EDUCATIONAL_EDUCATIONAL(),
	Category::EDUCATIONAL_EDUCATIONAL_WITH_STAY(),
	Category::CLUB_MEETING(),
	Category::CLUB_LECTURE(),
	Category::FOR_PUBLIC(),
	Category::ECO_TENT(),
	Category::EXHIBITION(),
	Category::INTERNAL_VOLUNTEER_MEETING(),
	Category::INTERNAL_GENERAL_MEETING(),
	Category::INTERNAL_SECTION_MEETING(),
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
