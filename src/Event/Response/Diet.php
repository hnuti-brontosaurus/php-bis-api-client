<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Response;

enum Diet: string
{
	case MEAT = 'meat';
	case VEGAN = 'vegan';
	case VEGETARIAN = 'vege';
}
