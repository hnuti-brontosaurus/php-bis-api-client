<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Response;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @deprecated use Diet instead
 * @method static Food VEGETARIAN()
 * @method static Food MEAT()
 * @method static Food VEGAN()
 */
abstract class Food extends Enum
{
	use AutoInstances;

	protected const VEGETARIAN = 'vege';
	protected const MEAT = 'meat';
	protected const VEGAN = 'vegan';
}
