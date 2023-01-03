<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;


final class Endpoint
{

	public static function EVENT(int $id): string
	{
		return \sprintf('web/events/%d/', $id);
	}

	public static function EVENTS(): string
	{
		return 'web/events/';
	}

	public static function ADMINISTRATIVE_UNITS(): string
	{
		return 'web/administration_units/';
	}

	public static function OPPORTUNITIES(): string
	{
		return 'web/opportunities/';
	}

	public static function OPPORTUNITY(int $id): string
	{
		return \sprintf('web/opportunities/%d/', $id);
	}

}
