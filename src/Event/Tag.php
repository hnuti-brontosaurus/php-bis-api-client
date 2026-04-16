<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event;

enum Tag: string
{
	case RETRO_EVENT = 'retro_event';
	case REGION_EVENT = 'region_event';
}
