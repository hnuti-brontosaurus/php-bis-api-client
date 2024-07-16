<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Request;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Region PRAHA()
 * @method static Region STREDOCESKY()
 * @method static Region JIHOCESKY()
 * @method static Region PLZENSKY()
 * @method static Region KARLOVARSKY()
 * @method static Region USTECKY()
 * @method static Region LIBERECKY()
 * @method static Region KRALOVEHRADECKY()
 * @method static Region PARDUBICKY()
 * @method static Region VYSOCINA()
 * @method static Region JIHOMORAVSKY()
 * @method static Region OLOMOUCKY()
 * @method static Region MORAVSKOSLEZSKY()
 * @method static Region ZLINSKY()
 */
final class Region extends Enum
{
	use AutoInstances;

	protected const PRAHA = 1;
	protected const STREDOCESKY = 2;
	protected const JIHOCESKY = 3;
	protected const PLZENSKY = 4;
	protected const KARLOVARSKY = 5;
	protected const USTECKY = 6;
	protected const LIBERECKY = 7;
	protected const KRALOVEHRADECKY = 8;
	protected const PARDUBICKY = 9;
	protected const VYSOCINA = 10;
	protected const JIHOMORAVSKY = 11;
	protected const OLOMOUCKY = 12;
	protected const MORAVSKOSLEZSKY = 13;
	protected const ZLINSKY = 14;

}
