<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Enums;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static IntendedFor ALL()
 * @method static IntendedFor YOUNG_AND_ADULT()
 * @method static IntendedFor KIDS()
 * @method static IntendedFor PARENTS_WITH_KIDS()
 * @method static IntendedFor FIRST_TIME_PARTICIPANT()
 */
final class IntendedFor extends Enum
{
	use AutoInstances;

	protected const ALL = 'for_all';
	protected const YOUNG_AND_ADULT = 'for_young_and_adult';
	protected const KIDS = 'for_kids';
	protected const PARENTS_WITH_KIDS = 'for_parents_with_kids';
	protected const FIRST_TIME_PARTICIPANT = 'for_first_time_participant';
}
