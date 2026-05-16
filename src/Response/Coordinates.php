<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response;

use Stringable;
use function sprintf;


final readonly class Coordinates implements Stringable
{

	private function __construct(
		public float $latitude,
		public float $longitude,
	) {}


	public static function from(float $latitude, float $longitude): self
	{
		return new self($latitude, $longitude);
	}


	public function __toString(): string
	{
		return sprintf('%s,%s', $this->latitude, $this->longitude);
	}

}
