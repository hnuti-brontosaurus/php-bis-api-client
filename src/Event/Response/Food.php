<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Response;

/**
 * @deprecated use Diet instead
 */
enum Food: string
{
	case VEGETARIAN = 'vege';
	case MEAT = 'meat';
	case VEGAN = 'vegan';
}
