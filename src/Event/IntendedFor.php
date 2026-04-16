<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event;

enum IntendedFor: string
{
	case ALL = 'for_all';
	case YOUNG_AND_ADULT = 'for_young_and_adult';
	case KIDS = 'for_kids';
	case PARENTS_WITH_KIDS = 'for_parents_with_kids';
	case FIRST_TIME_PARTICIPANT = 'for_first_time_participant';
}
