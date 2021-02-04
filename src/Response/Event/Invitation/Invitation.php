<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisApiClient\Response\Event\Invitation;


final class Invitation
{

	private string $introduction;
	private string $organizationalInformation;
	private ?string $accommodation;
	private Food $food;
	private ?string $workDescription;
	private ?int $workHoursPerDay;
	private ?Presentation $presentation;


	/**
	 * @param string[] $presentationPhotos
	 */
	private function __construct(
		string $introduction,
		string $organizationalInformation,
		?string $accommodation,
		?int $food,
		?string $workDescription,
		?int $workHoursPerDay,
		?string $presentationText,
		array $presentationPhotos,
	) {
		$this->introduction = $introduction;
		$this->organizationalInformation = $organizationalInformation;

		if ($accommodation !== null) {
			$this->accommodation = $accommodation;
		}

		$this->food = Food::from($food);

		$this->workDescription = $workDescription;

		if ($workHoursPerDay !== null) {
			$this->workHoursPerDay = $workHoursPerDay;
		}

		if ($presentationText !== null || \count($presentationPhotos) > 0) {
			$this->presentation = Presentation::from($presentationText, $presentationPhotos);
		}
	}

	/**
	 * @param string[] $presentationPhotos
	 */
	public static function from(
		string $introduction,
		string $organizationalInformation,
		?string $accommodation,
		?int $food,
		?string $workDescription,
		?int $workHoursPerDay,
		?string $presentationText,
		array $presentationPhotos,
	): static
	{
		return new static(
			$introduction,
			$organizationalInformation,
			$accommodation,
			$food,
			$workDescription,
			$workHoursPerDay,
			$presentationText,
			$presentationPhotos
		);
	}


	/**
	 * @return string
	 */
	public function getIntroduction()
	{
		return $this->introduction;
	}

	/**
	 * @return string
	 */
	public function getOrganizationalInformation()
	{
		return $this->organizationalInformation;
	}

	/**
	 * @return bool
	 */
	public function isAccommodationListed()
	{
		return $this->accommodation !== null;
	}

	/**
	 * @return string|null
	 */
	public function getAccommodation()
	{
		return $this->accommodation;
	}

	/**
	 * @return Food
	 */
	public function getFood()
	{
		return $this->food;
	}

	/**
	 * @return string|null
	 */
	public function getWorkDescription()
	{
		return $this->workDescription;
	}

	/**
	 * @return bool
	 */
	public function areWorkHoursPerDayListed()
	{
		return $this->workHoursPerDay !== null;
	}

	/**
	 * @return int|null
	 */
	public function getWorkHoursPerDay()
	{
		return $this->workHoursPerDay;
	}

	/**
	 * @return bool
	 */
	public function hasPresentation()
	{
		return $this->presentation !== null;
	}

	/**
	 * @return Presentation|null
	 */
	public function getPresentation()
	{
		return $this->presentation;
	}

}
