<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\Event;


final class Photo
{

	private function __construct(
		private string $smallSizePath,
		private string $mediumSizePath,
		private string $largeSizePath,
		private string $originalSizePath,
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


	public function getSmallSizePath(): string
	{
		return $this->smallSizePath;
	}


	public function getMediumSizePath(): string
	{
		return $this->mediumSizePath;
	}


	public function getLargeSizePath(): string
	{
		return $this->largeSizePath;
	}


	public function getOriginalSizePath(): string
	{
		return $this->originalSizePath;
	}

}
