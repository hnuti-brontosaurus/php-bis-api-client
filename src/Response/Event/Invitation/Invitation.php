<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\Event\Invitation;


final class Invitation
{

	/**
	 * @param Food[] $food
	 */
	private function __construct(
		private string $introduction,
		private string $organizationalInformation,
		private string $accommodation,
		private array $food,
		private ?string $workDescription,
		private ?int $workHoursPerDay,
		private ?Presentation $presentation,
	) {}


	/**
	 * @param Food[] $food
	 */
	public static function from(
		string $introduction,
		string $organizationalInformation,
		string $accommodation,
		array $food,
		?string $workDescription,
		?int $workHoursPerDay,
		?Presentation $presentation,
	): self
	{
		return new self(
			$introduction,
			$organizationalInformation,
			$accommodation,
			$food,
			$workDescription,
			$workHoursPerDay,
			$presentation,
		);
	}


	public function getIntroduction(): string
	{
		return $this->introduction;
	}


	public function getOrganizationalInformation(): string
	{
		return $this->organizationalInformation;
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


	public function getWorkHoursPerDay(): ?int
	{
		return $this->workHoursPerDay;
	}


	public function getPresentation(): ?Presentation
	{
		return $this->presentation;
	}

}
