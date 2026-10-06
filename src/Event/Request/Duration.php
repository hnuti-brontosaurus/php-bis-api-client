<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Request;


final readonly class Duration
{
	private function __construct(
		public int $value,
		public string $parameter,
	)
	{}

	public static function exactly(int $value): self
	{
		return new self($value, 'duration');
	}

	public static function moreThan(int $value): self
	{
		return new self($value + 1, 'duration__gte');
	}

	public static function lessThan(int $value): self
	{
		return new self($value - 1, 'duration__lte');
	}

}