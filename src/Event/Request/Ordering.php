<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Request;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Ordering START_DATE_ASC()
 * @method static Ordering START_DATE_DESC()
 * @method static Ordering END_DATE_ASC()
 * @method static Ordering END_DATE_DESC()
 */
final class Ordering extends Enum
{
	use AutoInstances;

	protected const START_DATE_ASC = 'start';
	protected const START_DATE_DESC = '-start';
	protected const END_DATE_ASC = 'end';
	protected const END_DATE_DESC = '-end';
}
