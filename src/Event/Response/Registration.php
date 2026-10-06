<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Response;


final readonly class Registration
{

	private function __construct(
		public bool $isRegistrationRequired,
		public bool $isEventFull,
	) {}


	public static function from(
		bool $isRegistrationRequired,
		bool $isEventFull,
	): self
	{
		return new self($isRegistrationRequired, $isEventFull);
	}

}
