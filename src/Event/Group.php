<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Group CAMP()
 * @method static Group WEEKEND_EVENT()
 * @method static Group OTHER()
 */
final class Group extends Enum
{
	use AutoInstances;

	protected const CAMP = 'camp';
	protected const WEEKEND_EVENT = 'weekend_event';
	protected const OTHER = 'other';
}
