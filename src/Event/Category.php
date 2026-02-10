<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Category EVP()
 * @method static Category EXPERIENTAL()
 * @method static Category INTERNAL()
 * @method static Category INTERNAL_EDUCATIONAL()
 * @method static Category PRESENTATION()
 * @method static Category PUBLIC_EDUCATIONAL()
 * @method static Category SECTION_EVENT()
 * @method static Category SECTION_MEETING()
 * @method static Category VOLUNTEERING()
 */
final class Category extends Enum
{
	use AutoInstances;

	protected const EVP = 'evp'; // výukový program (EVP)
	protected const EXPERIENTAL = 'experiential'; // zážitková akce
	protected const INTERNAL = 'internal'; // interní akce
	protected const INTERNAL_EDUCATIONAL = 'internal_educational'; // vzdělávací pro organizátory HB
	protected const PRESENTATION = 'presentation'; // prezentační akce
	protected const PUBLIC_EDUCATIONAL = 'public_educational'; // vzdělávací pro veřejnost
	protected const SECTION_EVENT = 'section_event'; // oddílová akce
	protected const SECTION_MEETING = 'section_meeting'; // oddílová schůzka
	protected const VOLUNTEERING = 'volunteering'; // dobrovolnická akce

}
