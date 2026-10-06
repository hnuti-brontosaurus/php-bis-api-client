<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response;


final readonly class ContactPerson
{

	private function __construct(
		public ?string $name,
		public string $emailAddress,
		public ?string $phoneNumber,
	)
	{}


	public static function from(
		?string $name,
		string $emailAddress,
		?string $phoneNumber,
	): self
	{
		return new self($name, $emailAddress, $phoneNumber);
	}

}
