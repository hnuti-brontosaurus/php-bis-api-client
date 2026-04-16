<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Opportunity;

enum Category: string
{
	case ORGANIZING = 'organizing'; // organizování akcí
	case COLLABORATION = 'collaboration'; // spolupráce
	case LOCATION_HELP = 'location_help'; // pomoc lokalitě
}
