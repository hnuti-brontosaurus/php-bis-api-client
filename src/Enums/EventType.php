<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Enums;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static EventType VOLUNTARY()
 * @method static EventType VOLUNTARY_WITH_EXPERIENCE()
 * @method static EventType EXPERIENCE()
 * @method static EventType SPORT()
 * @method static EventType EDUCATIONAL_LECTURE()
 * @method static EventType EDUCATIONAL_COURSE()
 * @method static EventType EDUCATIONAL_OHB()
 * @method static EventType EDUCATIONAL_PROGRAM()
 * @method static EventType EDUCATIONAL_PROGRAM_WITH_STAY()
 * @method static EventType CLUB_MEETUP()
 * @method static EventType CLUB_TALK()
 * @method static EventType FOR_PUBLIC()
 * @method static EventType EKOSTAN()
 * @method static EventType EXHIBITION()
 * @method static EventType INTERNAL_VOLUNTEER_MEETING()
 * @method static EventType INTERNAL_GENERAL_MEETING()
 * @method static EventType INTERNAL_GROUP_MEETING()
 */
final class EventType extends Enum
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
