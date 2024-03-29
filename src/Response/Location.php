<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response;


final class Location
{

	private function __construct(
		private string $name,
		private ?Coordinates $coordinates,
	) {}


	public static function from(
		string $name,
		?Coordinates $coordinates,
	): self
	{
		return new self($name, $coordinates);
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getCoordinates(): ?Coordinates
	{
		return $this->coordinates;
	}

}
