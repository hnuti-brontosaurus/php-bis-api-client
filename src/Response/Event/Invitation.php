<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\Event;


final class Invitation
{

	/**
	 * @param Food[] $food
	 */
	private function __construct(
		private string $introduction,
		private string $practicalInformation,
		private string $accommodation,
		private array $food,
		private ?string $workDescription,
		private ?int $workDays,
		private ?int $workHoursPerDay,
		private ?Presentation $presentation,
	) {}


	/**
	 * @param Food[] $food
	 */
	public static function from(
		string $introduction,
		string $practicalInformation,
		string $accommodation,
		array $food,
		?string $workDescription,
		?int $workDays,
		?int $workHoursPerDay,
		?Presentation $presentation,
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
			$presentation,
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


	public function getPresentation(): ?Presentation
	{
		return $this->presentation;
	}

}
