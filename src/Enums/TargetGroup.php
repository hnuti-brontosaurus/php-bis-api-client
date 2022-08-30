<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Enums;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static TargetGroup EVERYONE()
 * @method static TargetGroup ADULTS()
 * @method static TargetGroup CHILDREN()
 * @method static TargetGroup FAMILIES()
 * @method static TargetGroup FIRST_TIME_ATTENDEES()
 */
final class TargetGroup extends Enum
{
	use AutoInstances;

	protected const EVERYONE = 'for_all';
	protected const ADULTS = 'for_young_and_adult';
	protected const CHILDREN = 'for_kids';
	protected const FAMILIES = 'for_parents_with_kids';
	protected const FIRST_TIME_ATTENDEES = 'for_first_time_participant';
}
