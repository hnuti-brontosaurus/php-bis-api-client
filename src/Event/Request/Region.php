<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Request;

enum Region: int
{
	case PRAHA = 1;
	case STREDOCESKY = 2;
	case JIHOCESKY = 3;
	case PLZENSKY = 4;
	case KARLOVARSKY = 5;
	case USTECKY = 6;
	case LIBERECKY = 7;
	case KRALOVEHRADECKY = 8;
	case PARDUBICKY = 9;
	case VYSOCINA = 10;
	case JIHOMORAVSKY = 11;
	case OLOMOUCKY = 12;
	case MORAVSKOSLEZSKY = 13;
	case ZLINSKY = 14;
}
