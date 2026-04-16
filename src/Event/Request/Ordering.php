<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Request;

enum Ordering: string
{
	case START_DATE_ASC = 'start';
	case START_DATE_DESC = '-start';
	case END_DATE_ASC = 'end';
	case END_DATE_DESC = '-end';
}
