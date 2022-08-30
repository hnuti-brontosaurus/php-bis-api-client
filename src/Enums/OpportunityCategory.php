<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Enums;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static OpportunityCategory ORGANIZING()
 * @method static OpportunityCategory COLLABORATION()
 * @method static OpportunityCategory LOCATION_HELP()
 */
final class OpportunityCategory extends Enum
{
	use AutoInstances;

	protected const ORGANIZING = 'organizing'; // organizování akcí
	protected const COLLABORATION = 'collaboration'; // spolupráce
	protected const LOCATION_HELP = 'location_help'; // pomoc lokalitě
}
