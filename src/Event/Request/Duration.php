<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Request;


final class Duration
{
	private function __construct(
		private readonly int $value,
		private readonly string $parameter,
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

	public function getValue(): int
	{
		return $this->value;
	}

	public function getParameter(): string
	{
		return $this->parameter;
	}
}