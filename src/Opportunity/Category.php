<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Opportunity;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Category ORGANIZING()
 * @method static Category COLLABORATION()
 * @method static Category LOCATION_HELP()
 */
final class Category extends Enum
{
	use AutoInstances;

	protected const ORGANIZING = 'organizing'; // organizování akcí
	protected const COLLABORATION = 'collaboration'; // spolupráce
	protected const LOCATION_HELP = 'location_help'; // pomoc lokalitě
}
