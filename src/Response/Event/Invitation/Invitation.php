<?php

namespace HnutiBrontosaurus\BisApiClient\Response\Event\Invitation;


final class Invitation
{

	/** @var string */
	private $introduction;

	/** @var string */
	private $organizationalInformation;

	/** @var string */
	private $workDescription;

	/** @var bool */
	private $hasPresentation = false;

	/** @var Presentation|null */
	private $presentation;


	/**
	 * @param string $introduction
	 * @param string $organizationalInformation
	 * @param string $workDescription
	 * @param string|null $presentationText
	 * @param string[] $presentationPhotos
	 */
	private function __construct(
		$introduction,
		$organizationalInformation,
		$workDescription,
		$presentationText = null,
		array $presentationPhotos = []
	) {
		$this->introduction = $introduction;
		$this->organizationalInformation = $organizationalInformation;
		$this->workDescription = $workDescription;

		if ($presentationText !== null) {
			$this->hasPresentation = true;
			$this->presentation = Presentation::from($presentationText);

			if (\count($presentationPhotos) > 0) {
				$this->presentation->addPhotos($presentationPhotos);
			}
		}
	}

	/**
	 * @param string $introduction
	 * @param string $organizationalInformation
	 * @param string $workDescription
	 * @param string|null $presentationText
	 * @param string[] $presentationPhotos
	 * @return self
	 */
	public static function from(
		$introduction,
		$organizationalInformation,
		$workDescription,
		$presentationText = null,
		array $presentationPhotos = []
	) {
		return new self(
			$introduction,
			$organizationalInformation,
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
	 * @return string
	 */
	public function getWorkDescription()
	{
		return $this->workDescription;
	}

	/**
	 * @return Presentation|null
	 */
	public function getPresentation()
	{
		return $this->presentation;
	}

}
