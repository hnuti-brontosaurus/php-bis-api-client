<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Enums;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static EventCategory VOLUNTARY()
 * @method static EventCategory VOLUNTARY_WITH_EXPERIENCE()
 * @method static EventCategory EXPERIENCE()
 * @method static EventCategory SPORT()
 * @method static EventCategory EDUCATIONAL_LECTURE()
 * @method static EventCategory EDUCATIONAL_COURSE()
 * @method static EventCategory EDUCATIONAL_OHB()
 * @method static EventCategory EDUCATIONAL_PROGRAM()
 * @method static EventCategory EDUCATIONAL_PROGRAM_WITH_STAY()
 * @method static EventCategory CLUB_MEETUP()
 * @method static EventCategory CLUB_TALK()
 * @method static EventCategory FOR_PUBLIC()
 * @method static EventCategory EKOSTAN()
 * @method static EventCategory EXHIBITION()
 * @method static EventCategory INTERNAL_VOLUNTEER_MEETING()
 * @method static EventCategory INTERNAL_GENERAL_MEETING()
 * @method static EventCategory INTERNAL_GROUP_MEETING()
 */
final class EventCategory extends Enum
{
	use AutoInstances;

	protected const VOLUNTARY = 'public__volunteering__only_volunteering';
	protected const VOLUNTARY_WITH_EXPERIENCE = 'public__volunteering__with_experience';
	protected const EXPERIENCE = 'public__only_experiential';
	protected const SPORT = 'public__sports';

	// vzdělávací / educational
	protected const EDUCATIONAL_LECTURE = 'public__educational__lecture'; // přednáška
	protected const EDUCATIONAL_COURSE = 'public__educational__course'; // kurz, školení
	protected const EDUCATIONAL_OHB = 'public__educational__ohb'; // ohb
	protected const EDUCATIONAL_PROGRAM = 'public__educational__educational'; // výukový program
	protected const EDUCATIONAL_PROGRAM_WITH_STAY = 'public__educational__educational_with_stay'; // pobytový výukový program

	// klub / club
	protected const CLUB_MEETUP = 'public__club__meeting'; // setkání
	protected const CLUB_TALK = 'public__club__lecture'; // přednáška

	// ostatní / other
	protected const FOR_PUBLIC = 'public__other__for_public'; // akce pro veřejnost
	protected const EXHIBITION = 'public__other__exhibition'; // výstava
	protected const EKOSTAN = 'public__other__eco_tent'; // ekostan

	// interní / internal
	protected const INTERNAL_VOLUNTEER_MEETING = 'internal__volunteer_meeting'; // schůzka dobrovolníků, týmovka
	protected const INTERNAL_GENERAL_MEETING = 'internal__general_meeting'; // valná hromada
	protected const INTERNAL_GROUP_MEETING = 'internal__section_meeting'; // oddílová, družinová schůzka
}
