<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Enums;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static EventGroup CAMP()
 * @method static EventGroup WEEKEND_EVENT()
 * @method static EventGroup OTHER()
 */
final class EventGroup extends Enum
{
	use AutoInstances;

	protected const CAMP = 'camp';
	protected const WEEKEND_EVENT = 'weekend_event';
	protected const OTHER = 'other';
}
