<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\Event;


final class Invitation
{

	/**
	 * @param Food[] $food
	 * @param Photo[] $photos
	 */
	private function __construct(
		private string $introduction,
		private string $practicalInformation,
		private string $accommodation,
		private array $food,
		private ?string $workDescription,
		private ?int $workDays,
		private ?int $workHoursPerDay,
		private ?string $aboutUs,
		private array $photos,
	) {}


	/**
	 * @param Food[] $food
	 * @param Photo[] $photos
	 */
	public static function from(
		string $introduction,
		string $practicalInformation,
		string $accommodation,
		array $food,
		?string $workDescription,
		?int $workDays,
		?int $workHoursPerDay,
		?string $text,
		array $photos,
	): self
	{
		return new self(
			$introduction,
			$practicalInformation,
			$accommodation,
			$food,
			$workDescription,
			$workDays,
			$workHoursPerDay,
			$text,
			$photos,
		);
	}


	public function getIntroduction(): string
	{
		return $this->introduction;
	}


	public function getPracticalInformation(): string
	{
		return $this->practicalInformation;
	}


	public function getAccommodation(): string
	{
		return $this->accommodation;
	}


	/**
	 * @return Food[]
	 */
	public function getFood(): array
	{
		return $this->food;
	}


	public function getWorkDescription(): ?string
	{
		return $this->workDescription;
	}


	public function getWorkDays(): ?int
	{
		return $this->workDays;
	}


	public function getWorkHoursPerDay(): ?int
	{
		return $this->workHoursPerDay;
	}


	public function getAboutUs(): ?string
	{
		return $this->aboutUs;
	}


	/**
	 * @return Photo[]
	 */
	public function getPhotos(): array
	{
		return $this->photos;
	}

}
