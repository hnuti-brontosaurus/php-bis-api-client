<?php

namespace HnutiBrontosaurus\BisApiClient\Response\Event\Invitation;


final class Invitation
{

	/** @var string */
	private $introduction;

	/** @var string */
	private $organizationalInformation;

	/** @var string|null */
	private $accommodation;

	/** @var string|null */
	private $food;

	/** @var string */
	private $workDescription;

	/** @var Presentation|null */
	private $presentation;


	/**
	 * @param string $introduction
	 * @param string $organizationalInformation
	 * @param string|null $accommodation
	 * @param string|null $food
	 * @param string $workDescription
	 * @param string|null $presentationText
	 * @param string[] $presentationPhotos
	 */
	private function __construct(
		$introduction,
		$organizationalInformation = null,
		$accommodation = null,
		$food,
		$workDescription,
		$presentationText = null,
		array $presentationPhotos = []
	) {
		$this->introduction = $introduction;
		$this->organizationalInformation = $organizationalInformation;

		if ($accommodation !== null) {
			$this->accommodation = $accommodation;
		}
		if ($food !== null) {
			$this->food = $food;
		}

		$this->workDescription = $workDescription;

		if ($presentationText !== null) {
			$this->presentation = Presentation::from($presentationText);

			if (\count($presentationPhotos) > 0) {
				$this->presentation->addPhotos($presentationPhotos);
			}
		}
	}

	/**
	 * @param string $introduction
	 * @param string $organizationalInformation
	 * @param string|null $accommodation
	 * @param string|null $food
	 * @param string $workDescription
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
		$presentationText = null,
		array $presentationPhotos = []
	) {
		return new self(
			$introduction,
			$organizationalInformation,
			$accommodation,
			$food,
			$workDescription,
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
	 * @return bool
	 */
	public function isFoodListed()
	{
		return $this->food !== null;
	}

	/**
	 * @return string|null
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
