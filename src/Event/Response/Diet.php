<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Response;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Diet MEAT()
 * @method static Diet VEGAN()
 * @method static Diet VEGETARIAN()
 */
final class Diet extends Enum
{
	use AutoInstances;

	protected const MEAT = 'meat';
	protected const VEGAN = 'vegan';
	protected const VEGETARIAN = 'vege';
}
