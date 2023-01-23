<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Response;


final class Registration
{

	private function __construct(
		private bool $isRegistrationRequired,
		private bool $isEventFull,
	) {}


	public static function from(
		bool $isRegistrationRequired,
		bool $isEventFull,
	): self
	{
		return new self($isRegistrationRequired, $isEventFull);
	}


	public function getIsRegistrationRequired(): bool
	{
		return $this->isRegistrationRequired;
	}


	public function getIsEventFull(): bool
	{
		return $this->isEventFull;
	}

}
