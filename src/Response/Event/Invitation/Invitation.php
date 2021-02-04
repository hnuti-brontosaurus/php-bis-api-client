<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisApiClient\Response\Event\Invitation;


final class Invitation
{

	/** @var string */
	private $introduction;

	/** @var string */
	private $organizationalInformation;

	/** @var string|null */
	private $accommodation;

	/** @var Food */
	private $food;

	/** @var string */
	private $workDescription;

	/** @var int|null */
	private $workHoursPerDay;

	/** @var Presentation|null */
	private $presentation;


	/**
	 * @param string $introduction
	 * @param string $organizationalInformation
	 * @param string|null $accommodation
	 * @param int|null $food
	 * @param string $workDescription
	 * @param int|null $workHoursPerDay
	 * @param string|null $presentationText
	 * @param string[] $presentationPhotos
	 */
	private function __construct(
		$introduction,
		$organizationalInformation = null,
		$accommodation = null,
		$food,
		$workDescription,
		$workHoursPerDay = null,
		$presentationText = null,
		array $presentationPhotos = []
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
	 * @param string $introduction
	 * @param string $organizationalInformation
	 * @param string|null $accommodation
	 * @param int|null $food
	 * @param string $workDescription
	 * @param int|null $workHoursPerDay
	 * @param string|null $presentationText
	 * @param string[] $presentationPhotos
	 * @return self
	 */
	public static function from(
		$introduction,
		$organizationalInformation,
		$accommodation = null,
		$food = null,
		$workDescription,
		$workHoursPerDay = null,
		$presentationText = null,
		array $presentationPhotos = []
	) {
		return new self(
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
	 * @return string
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
