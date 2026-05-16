<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response;


final readonly class Location
{

	private function __construct(
		public string $name,
		public ?Coordinates $coordinates,
	) {}


	public static function from(
		string $name,
		?Coordinates $coordinates,
	): self
	{
		return new self($name, $coordinates);
	}

}
