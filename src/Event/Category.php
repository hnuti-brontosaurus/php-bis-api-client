<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Category VOLUNTEERING()
 * @method static Category EXPERIENCE()
 * @method static Category EDUCATIONAL_LECTURE()
 * @method static Category EDUCATIONAL_COURSE()
 * @method static Category EDUCATIONAL_OHB()
 * @method static Category EDUCATIONAL_EDUCATIONAL()
 * @method static Category EDUCATIONAL_EDUCATIONAL_WITH_STAY()
 * @method static Category CLUB_MEETING()
 * @method static Category CLUB_LECTURE()
 * @method static Category FOR_PUBLIC()
 * @method static Category ECO_TENT()
 * @method static Category EXHIBITION()
 * @method static Category INTERNAL_VOLUNTEER_MEETING()
 * @method static Category INTERNAL_GENERAL_MEETING()
 * @method static Category INTERNAL_SECTION_MEETING()
 */
final class Category extends Enum
{
	use AutoInstances;

	protected const VOLUNTEERING = 'public__volunteering';
	protected const EXPERIENCE = 'public__only_experiential';

	// vzdělávací / educational
	protected const EDUCATIONAL_LECTURE = 'public__educational__lecture'; // přednáška
	protected const EDUCATIONAL_COURSE = 'public__educational__course'; // kurz, školení
	protected const EDUCATIONAL_OHB = 'public__educational__ohb'; // ohb
	protected const EDUCATIONAL_EDUCATIONAL = 'public__educational__educational'; // výukový program
	protected const EDUCATIONAL_EDUCATIONAL_WITH_STAY = 'public__educational__educational_with_stay'; // pobytový výukový program

	// klub / club
	protected const CLUB_MEETING = 'public__club__meeting'; // setkání
	protected const CLUB_LECTURE = 'public__club__lecture'; // přednáška

	// ostatní / other
	protected const FOR_PUBLIC = 'public__other__for_public'; // akce pro veřejnost
	protected const EXHIBITION = 'public__other__exhibition'; // výstava
	protected const ECO_TENT = 'public__other__eco_tent'; // ekostan

	// interní / internal
	protected const INTERNAL_VOLUNTEER_MEETING = 'internal__volunteer_meeting'; // schůzka dobrovolníků, týmovka
	protected const INTERNAL_GENERAL_MEETING = 'internal__general_meeting'; // valná hromada
	protected const INTERNAL_SECTION_MEETING = 'internal__section_meeting'; // oddílová, družinová schůzka
}
