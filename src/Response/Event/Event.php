<?php

namespace HnutiBrontosaurus\BisApiClient\Response\Event;

use HnutiBrontosaurus\BisApiClient\Response\Event\Invitation\Invitation;
use HnutiBrontosaurus\BisApiClient\Response\Event\Registration\RegistrationType;


final class Event
{

	/** @var int */
	private $id;

	/** @var string */
	private $name;

	/** @var string|null */
	private $coverPhotoPath;

	/** @var \DateTimeImmutable */
	private $dateFrom;

	/** @var \DateTimeImmutable */
	private $dateUntil;

	/** @var string */
	private $type;

	/** @var Program|null */
	private $program;

	/** @var Place */
	private $place;

	/** @var RegistrationType */
	private $registrationType;

	/** @var int|null */
	private $ageFrom;

	/** @var int|null */
	private $ageUntil;

	/**
	 * Single number or interval.
	 * @var int|string
	 */
	private $price;

	/** @var Organizer */
	private $organizer;

	/** @var Invitation|null */
	private $invitation;

	/** @var string|null */
	private $meetingInformation;

	/** @var int|null */
	private $workingTime;

	/** @var string|null */
	private $programDescription;

	/** @var string|null */
	private $accommodation;

	/** @var string|null */
	private $food;

	/** @var string|null */
	private $notes;


	/**
	 * @param int $id
	 * @param string $name
	 * @param \DateTimeImmutable $dateFrom
	 * @param \DateTimeImmutable $dateUntil
	 * @param string $type
	 * @param string|null $programSlug
	 * @param string|null $programName
	 * @param int|null $placeId
	 * @param string $placeName
	 * @param int $registrationType
	 * @param string|null $webRegistrationQuestion1
	 * @param string|null $webRegistrationQuestion2
	 * @param string|null $webRegistrationQuestion3
	 * @param string|null $registrationCustomUrl
	 * @param int|null $ageFrom
	 * @param int|null $ageUntil
	 * @param int|string $price
	 * @param int|null $organizationalUnitId
	 * @param string|null $organizationalUnitName
	 * @param string|null $organizers
	 * @param string|null $contactPersonName
	 * @param string $contactPhone
	 * @param string $contactEmail
	 * @param string|null $contactWebsite
	 * @param string|null $invitationOrganizationalInformation
	 * @param string|null $invitationIntroduction
	 * @param string|null $invitationPresentationText
	 * @param array $invitationPresentationPhotos
	 * @param string|null $invitationWorkDescription
	 * @param string|null $meetingInformation
	 * @param string|null $responsiblePerson
	 * @param int|null $workingTime
	 * @param string|null $programDescription
	 * @param string|null $accommodation
	 * @param string|null $food
	 * @param string|null $notes
	 * @param string|null $mapLinkOrCoords
	 */
	private function __construct(
		$id,
		$name,
		\DateTimeImmutable $dateFrom,
		\DateTimeImmutable $dateUntil,
		$type,
		$programSlug = null,
		$programName = null,
		$placeId = null,
		$placeName,
		$registrationType,
		$webRegistrationQuestion1 = null,
		$webRegistrationQuestion2 = null,
		$webRegistrationQuestion3 = null,
		$registrationCustomUrl = null,
		$ageFrom = null,
		$ageUntil = null,
		$price = null,
		$organizationalUnitId = null,
		$organizationalUnitName = null,
		$organizers = null,
		$contactPersonName = null,
		$contactPhone,
		$contactEmail,
		$contactWebsite = null,
		$invitationOrganizationalInformation = null,
		$invitationIntroduction = null,
		$invitationPresentationText = null,
		array $invitationPresentationPhotos = [],
		$invitationWorkDescription = null,
		$meetingInformation = null,
		$responsiblePerson = null,
		$workingTime = null,
		$programDescription = null,
		$accommodation = null,
		$food = null,
		$notes = null,
		$mapLinkOrCoords = null
	) {
		$this->id = $id;
		$this->name = $name;
		$this->dateFrom = $dateFrom;
		$this->dateUntil = $dateUntil;
		$this->type = $type;
		$this->place = Place::from($placeId, $placeName, $mapLinkOrCoords);
		$this->ageFrom = $ageFrom;
		$this->ageUntil = $ageUntil;
		$this->price = $price;
		$this->meetingInformation = $meetingInformation;
		$this->workingTime = $workingTime;
		$this->programDescription = $programDescription;
		$this->accommodation = $accommodation;
		$this->food = $food;
		$this->notes = $notes;


		// cover photo

		if (\count($invitationPresentationPhotos) > 0) {
			$this->coverPhotoPath = \reset($invitationPresentationPhotos);
		}


		// program

		if ($programSlug !== null && $programName !== null) {
			$this->program = Program::from($programSlug, $programName);
		}


		// registration

		$registrationQuestions = \array_filter([ // exclude all null items
			$webRegistrationQuestion1,
			$webRegistrationQuestion2,
			$webRegistrationQuestion3,
		], function ($v, $k) {
			return $v !== null;
		}, ARRAY_FILTER_USE_BOTH);
		$this->registrationType = RegistrationType::from($registrationType, $registrationQuestions, $contactEmail, $registrationCustomUrl);


		// organizers

		$this->organizer = Organizer::from(
			$organizationalUnitId,
			$organizationalUnitName,
			$responsiblePerson,
			$organizers,
			$contactPersonName,
			$contactPhone,
			$contactEmail,
			$contactWebsite
		);


		// invitation

		$this->invitation = Invitation::from(
			$invitationIntroduction,
			$invitationOrganizationalInformation,
			$invitationWorkDescription,
			$invitationPresentationText,
			$invitationPresentationPhotos
		);
	}


	/**
	 * @param string[] $data Everything is string as it comes from HTTP response body.
	 * @return self
	 */
	public static function fromResponseData(array $data)
	{
		$price = 0;
		if ($data['poplatek'] !== '') {
			$price = $data['poplatek'];

			if (\preg_match('|^[0-9]+$|', $price)) {
				$price = (int) $price;
			}
		}

		$invitationPresentationPhotos = [];
		if ($data['priloha_1'] !== '') {
			$invitationPresentationPhotos[] = $data['priloha_1'];
		}
		if ($data['priloha_2'] !== '') {
			$invitationPresentationPhotos[] = $data['priloha_2'];
		}
		if ($data['priloha_4'] !== '') {
			$invitationPresentationPhotos[] = $data['priloha_3'];
		}
		if ($data['priloha_4'] !== '') {
			$invitationPresentationPhotos[] = $data['priloha_4'];
		}
		if ($data['priloha_5'] !== '') {
			$invitationPresentationPhotos[] = $data['priloha_5'];
		}
		if ($data['priloha_6'] !== '') {
			$invitationPresentationPhotos[] = $data['priloha_6'];
		}

		return new self(
			(int)$data['id'],
			$data['nazev'],
			\DateTimeImmutable::createFromFormat('Y-m-d', $data['od']),
			\DateTimeImmutable::createFromFormat('Y-m-d', $data['do']),
			$data['typ'],
			$data['program_id'] !== '' ? $data['program_id'] : null,
			$data['program'] !== '' ? $data['program'] : null,
			$data['lokalita_id'] !== '' ? ((int) $data['lokalita_id']) : null,
			$data['lokalita'],
			(int) $data['prihlasovani_id'],
			$data['add_info_title'] !== '' ? $data['add_info_title'] : null,
			$data['add_info_title_2'] !== '' ? $data['add_info_title_2'] : null,
			$data['add_info_title_3'] !== '' ? $data['add_info_title_3'] : null,
			$data['kontakt_url'] !== '' ? $data['kontakt_url'] : null,
			$data['vek_od'] !== '' ? ((int) $data['vek_od']) : null,
			$data['vek_do'] !== '' ? ((int) $data['vek_do']) : null,
			$price,
			$data['porada_id'] !== '' ? ((int)$data['porada_id']) : null,
			$data['porada'] !== '' ? $data['porada'] : null,
			$data['org'] !== '' ? $data['org'] : null,
			$data['kontakt'] !== '' ? $data['kontakt'] : null,
			$data['kontakt_telefon'],
			$data['kontakt_email'],
			$data['web'] !== '' ? $data['web'] : null,
			$data['text_info'] !== '' ? $data['text_info'] : null,
			$data['text_uvod'] !== '' ? $data['text_uvod'] : null,
			$data['text_mnam'] !== '' ? $data['text_mnam'] : null,
			$invitationPresentationPhotos,
			$data['text_prace'] !== '' ? $data['text_prace'] : null,
			$data['sraz'] !== '' ? $data['sraz'] : null,
			$data['odpovedna'] !== '' ? $data['odpovedna'] : null,
			$data['pracovni_doba'] !== '' ? ((int) $data['pracovni_doba']) : null,
			$data['popis_programu'] !== '' ? $data['popis_programu'] : null,
			$data['ubytovani'] !== '' ? $data['ubytovani'] : null,
			$data['strava'] !== '' ? $data['strava'] : null,
			$data['jak_se_prihlasit'] !== '' ? $data['jak_se_prihlasit'] : null,
			$data['lokalita_mapa'] !== '' ? $data['lokalita_mapa'] : null
		);
	}


	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string|null
	 */
	public function getCoverPhotoPath()
	{
		return $this->coverPhotoPath;
	}

	/**
	 * @return bool
	 */
	public function hasCoverPhoto()
	{
		return $this->coverPhotoPath !== null;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return \DateTimeImmutable
	 */
	public function getDateFrom()
	{
		return $this->dateFrom;
	}

	/**
	 * @return \DateTimeImmutable
	 */
	public function getDateUntil()
	{
		return $this->dateUntil;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @return Program|null
	 */
	public function getProgram()
	{
		return $this->program;
	}

	/**
	 * @return Place
	 */
	public function getPlace()
	{
		return $this->place;
	}

	/**
	 * @return RegistrationType
	 */
	public function getRegistrationType()
	{
		return $this->registrationType;
	}

	/**
	 * @return int|null
	 */
	public function getAgeFrom()
	{
		return $this->ageFrom;
	}

	/**
	 * @return int|null
	 */
	public function getAgeUntil()
	{
		return $this->ageUntil;
	}

	/**
	 * @return int|string
	 */
	public function getPrice()
	{
		return $this->price;
	}

	public function isPaid()
	{
		return $this->price !== 0;
	}

	/**
	 * @return Organizer
	 */
	public function getOrganizer()
	{
		return $this->organizer;
	}

	/**
	 * @return Invitation|null
	 */
	public function getInvitation()
	{
		return $this->invitation;
	}

	/**
	 * @return string|null
	 */
	public function getMeetingInformation()
	{
		return $this->meetingInformation;
	}

	/**
	 * @return int|null
	 */
	public function getWorkingTime()
	{
		return $this->workingTime;
	}

	/**
	 * @return string|null
	 */
	public function getProgramDescription()
	{
		return $this->programDescription;
	}

	/**
	 * @return string|null
	 */
	public function getAccommodation()
	{
		return $this->accommodation;
	}

	/**
	 * @return string|null
	 */
	public function getFood()
	{
		return $this->food;
	}

	/**
	 * @return string|null
	 */
	public function getNotes()
	{
		return $this->notes;
	}

}
