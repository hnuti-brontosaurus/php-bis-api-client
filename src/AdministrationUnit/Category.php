<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\AdministrationUnit;

enum Category: string
{
	case CLUB = 'club';
	case BASIC_SECTION = 'basic_section';
	case REGIONAL_CENTER = 'regional_center';
	case HEADQUARTER = 'headquarter';
}
