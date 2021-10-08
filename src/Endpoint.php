<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;


final class Endpoint
{

	public static function AUTHENTICATION(): string
	{
		return 'o/token/';
	}

	public static function EVENT(int $id): string
	{
		return \sprintf('bronto/event/%d/', $id);
	}

	public static function EVENTS(): string
	{
		return 'bronto/event/';
	}

	public static function ADMINISTRATIVE_UNITS(): string
	{
		return 'bronto/administrative_unit/';
	}

	public static function ADD_ATTENDEE_TO_EVENT(): string
	{
		return 'bronto/register_userprofile_interaction/';
	}

}
