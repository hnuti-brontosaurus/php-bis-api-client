<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Enums;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static AdministrationUnitCategory CLUB()
 * @method static AdministrationUnitCategory BASIC_SECTION()
 * @method static AdministrationUnitCategory REGIONAL_CENTER()
 * @method static AdministrationUnitCategory HEADQUARTER()
 */
final class AdministrationUnitCategory extends Enum
{
	use AutoInstances;

	protected const CLUB = 'club';
	protected const BASIC_SECTION = 'basic_section';
	protected const REGIONAL_CENTER = 'regional_center';
	protected const HEADQUARTER = 'headquarter';
}
