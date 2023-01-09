<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Request;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Period UNLIMITED()
 * @method static Period RUNNING_ONLY()
 * @method static Period FUTURE_ONLY()
 * @method static Period PAST_ONLY()
 * @method static Period RUNNING_AND_FUTURE()
 * @method static Period RUNNING_AND_PAST()
 */
final class Period extends Enum
{
	use AutoInstances;

	protected const UNLIMITED = 'unlimited';
	protected const RUNNING_ONLY = 'runningOnly';
	protected const FUTURE_ONLY = 'futureOnly';
	protected const PAST_ONLY = 'pastOnly';
	protected const RUNNING_AND_FUTURE = 'runningAndFuture';
	protected const RUNNING_AND_PAST = 'runningAndPast';
}
