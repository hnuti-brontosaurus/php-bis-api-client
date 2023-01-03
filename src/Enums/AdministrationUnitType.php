<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Enums;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static AdministrationUnitType CLUB()
 * @method static AdministrationUnitType BASIC_SECTION()
 * @method static AdministrationUnitType REGIONAL_CENTER()
 * @method static AdministrationUnitType HEADQUARTER()
 */
final class AdministrationUnitType extends Enum
{
	use AutoInstances;

	protected const CLUB = 'club';
	protected const BASIC_SECTION = 'basic_section';
	protected const REGIONAL_CENTER = 'regional_center';
	protected const HEADQUARTER = 'headquarter';
}
