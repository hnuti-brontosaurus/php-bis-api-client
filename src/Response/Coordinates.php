<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response;


use function sprintf;


final class Coordinates
{

	private function __construct(
		private float $latitude,
		private float $longitude,
	) {}


	public static function from(float $latitude, float $longitude): self
	{
		return new self($latitude, $longitude);
	}


	public function getLatitude(): float
	{
		return $this->latitude;
	}


	public function getLongitude(): float
	{
		return $this->longitude;
	}


	public function __toString(): string
	{
		return sprintf('%s,%s', $this->latitude, $this->longitude);
	}

}
