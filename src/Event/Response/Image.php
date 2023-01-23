<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Response;


final class Image
{

	private function __construct(
		private string $small,
		private string $medium,
		private string $large,
		private string $original,
	) {}


	/** @param array{small: string, medium: string, large: string, original: string} $variants */
	public static function from(array $variants): self
	{
		return new self(
			$variants['small'],
			$variants['medium'],
			$variants['large'],
			$variants['original'],
		);
	}


	public function getSmall(): string
	{
		return $this->small;
	}


	public function getMedium(): string
	{
		return $this->medium;
	}


	public function getLarge(): string
	{
		return $this->large;
	}


	public function getOriginal(): string
	{
		return $this->original;
	}

}
