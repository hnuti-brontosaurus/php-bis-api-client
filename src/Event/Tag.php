<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Tag RETRO_EVENT()
 * @method static Tag REGION_EVENT()
 */
final class Tag extends Enum
{
	use AutoInstances;

	protected const RETRO_EVENT = 'retro_event';
	protected const REGION_EVENT = 'region_event';
}
