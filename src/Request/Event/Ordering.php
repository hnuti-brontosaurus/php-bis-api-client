<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Request\Event;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Ordering DATE_START_ASC()
 * @method static Ordering DATE_START_DESC()
 * @method static Ordering DATE_END_ASC()
 * @method static Ordering DATE_END_DESC()
 */
final class Ordering extends Enum
{
	use AutoInstances;

	protected const DATE_START_ASC = 'start';
	protected const DATE_START_DESC = '-start';
	protected const DATE_END_ASC = 'end';
	protected const DATE_END_DESC = '-end';
}
