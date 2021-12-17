<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\Event\Invitation;

use Grifart\Enum\AutoInstances;
use Grifart\Enum\Enum;


/**
 * @method static Food VEGETARIAN()
 * @method static Food NON_VEGETARIAN()
 * @method static Food VEGAN()
 * @method static Food KOSHER()
 * @method static Food HALAL()
 * @method static Food GLUTEN_FREE()
 */
final class Food extends Enum
{
	use AutoInstances;

	protected const VEGETARIAN = 'vegetarian';
	protected const NON_VEGETARIAN = 'non_vegetarian';
	protected const VEGAN = 'vegan';
	protected const KOSHER = 'kosher';
	protected const HALAL = 'halal';
	protected const GLUTEN_FREE = 'gluten_free';
}
