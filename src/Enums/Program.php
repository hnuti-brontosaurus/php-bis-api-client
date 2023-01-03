<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Enums;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Program NONE()
 * @method static Program NATURE()
 * @method static Program MONUMENTS()
 * @method static Program BRDO()
 * @method static Program EKOSTAN()
 * @method static Program PSB()
 * @method static Program EDUCATION()
 * @method static Program INTERNATIONAL()
 */
final class Program extends Enum
{
	use AutoInstances;

	protected const NONE = 'none';
	protected const NATURE = 'nature';
	protected const MONUMENTS = 'monuments';
	protected const BRDO = 'kids';
	protected const EKOSTAN = 'eco_tent';
	protected const PSB = 'holidays_with_brontosaurus';
	protected const EDUCATION = 'education';
	protected const INTERNATIONAL = 'international';
}
