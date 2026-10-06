<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response;


final readonly class Image
{

	private function __construct(
		public string $smallSizePath,
		public string $mediumSizePath,
		public string $largeSizePath,
		public string $originalSizePath,
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

}
