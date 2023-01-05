<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\Event;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Food VEGETARIAN()
 * @method static Food NON_VEGETARIAN()
 * @method static Food VEGAN()
 */
final class Food extends Enum
{
	use AutoInstances;

	protected const VEGETARIAN = 'vege';
	protected const NON_VEGETARIAN = 'meat';
	protected const VEGAN = 'vegan';
}
