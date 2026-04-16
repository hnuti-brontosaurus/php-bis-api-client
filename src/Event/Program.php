<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event;

enum Program: string
{
	case NONE = 'none';
	case NATURE = 'nature';
	case MONUMENTS = 'monuments';
	case KIDS = 'kids';
	case ECO_TENT = 'eco_tent';
	case HOLIDAYS_WITH_BRONTOSAURUS = 'holidays_with_brontosaurus';
	case EDUCATION = 'education';
	case INTERNATIONAL = 'international';
}
