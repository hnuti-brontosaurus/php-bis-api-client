<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\AdministrationUnit;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Category CLUB()
 * @method static Category BASIC_SECTION()
 * @method static Category REGIONAL_CENTER()
 * @method static Category HEADQUARTER()
 */
final class Category extends Enum
{
	use AutoInstances;

	protected const CLUB = 'club';
	protected const BASIC_SECTION = 'basic_section';
	protected const REGIONAL_CENTER = 'regional_center';
	protected const HEADQUARTER = 'headquarter';
}
