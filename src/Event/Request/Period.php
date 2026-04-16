<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Request;

enum Period: string
{
	case UNLIMITED = 'unlimited';
	case RUNNING_ONLY = 'runningOnly';
	case FUTURE_ONLY = 'futureOnly';
	case PAST_ONLY = 'pastOnly';
	case RUNNING_AND_FUTURE = 'runningAndFuture';
	case RUNNING_AND_PAST = 'runningAndPast';
}
