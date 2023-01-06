<?php declare(strict_types = 1);

use HnutiBrontosaurus\BisClient\BisClient;
use HnutiBrontosaurus\BisClient\Enums\EventCategory;
use HnutiBrontosaurus\BisClient\Enums\EventGroup;
use HnutiBrontosaurus\BisClient\Enums\IntendedFor;
use HnutiBrontosaurus\BisClient\Enums\Program;
use HnutiBrontosaurus\BisClient\Request\Event\EventParameters;


/** @var BisClient $client */
$client = require_once __DIR__ . '/bootstrap.php';


echo '<h2>Events</h2>';

$params = new EventParameters();
$params->setGroups([
	EventGroup::CAMP(),
	EventGroup::WEEKEND_EVENT(),
	EventGroup::OTHER(),
]);
$params->setCategories([
	EventCategory::VOLUNTARY(),
	EventCategory::EXPERIENCE(),
	EventCategory::EDUCATIONAL_LECTURE(),
	EventCategory::EDUCATIONAL_COURSE(),
	EventCategory::EDUCATIONAL_OHB(),
	EventCategory::EDUCATIONAL_PROGRAM(),
	EventCategory::EDUCATIONAL_PROGRAM_WITH_STAY(),
	EventCategory::CLUB_MEETUP(),
	EventCategory::CLUB_TALK(),
	EventCategory::FOR_PUBLIC(),
	EventCategory::EKOSTAN(),
	EventCategory::EXHIBITION(),
	EventCategory::INTERNAL_VOLUNTEER_MEETING(),
	EventCategory::INTERNAL_GENERAL_MEETING(),
	EventCategory::INTERNAL_GROUP_MEETING(),
]);
$params->setPrograms([
	Program::NONE(),
	Program::NATURE(),
	Program::MONUMENTS(),
	Program::BRDO(),
	Program::EKOSTAN(),
	Program::PSB(),
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
