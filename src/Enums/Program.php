<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Enums;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Program NONE()
 * @method static Program NATURE()
 * @method static Program MONUMENTS()
 * @method static Program KIDS()
 * @method static Program ECO_TENT()
 * @method static Program HOLIDAYS_WITH_BRONTOSAURUS()
 * @method static Program EDUCATION()
 * @method static Program INTERNATIONAL()
 */
final class Program extends Enum
{
	use AutoInstances;

	protected const NONE = 'none';
	protected const NATURE = 'nature';
	protected const MONUMENTS = 'monuments';
	protected const KIDS = 'kids';
	protected const ECO_TENT = 'eco_tent';
	protected const HOLIDAYS_WITH_BRONTOSAURUS = 'holidays_with_brontosaurus';
	protected const EDUCATION = 'education';
	protected const INTERNATIONAL = 'international';
}
