<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event;

enum Group: string
{
	case CAMP = 'camp';
	case WEEKEND_EVENT = 'weekend_event';
	case OTHER = 'other';
}
