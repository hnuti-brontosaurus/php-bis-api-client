<?php

namespace HnutiBrontosaurus\BisApiClient\Response\Event;


final class Event
{

	/** @var int */
	private $id;

	/** @var string */
	private $name;

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

	/** @var bool */
	private $enableWebRegistration = false;

	/** @var RegistrationQuestion[]|array */
	private $webRegistrationQuestions = [];

	/** @var int|null */
	private $ageFrom;

	/** @var int|null */
	private $ageUntil;

	/**
	 * Single number, interval or null.
	 * @var int|string|null
	 */
	private $price;

	/** @var Organizer */
	private $organizer;

	/** @var string|null */
	private $invitationText;

	/** @var string|null */
	private $workDescription;

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

	/** @var array */
	private $attachments = [];


	/**
	 * Event constructor.
	 * @param int $id
	 * @param string $name
	 * @param \DateTimeImmutable $dateFrom
	 * @param \DateTimeImmutable $dateUntil
	 * @param string $type
	 * @param string|null $programSlug
	 * @param string|null $programName
	 * @param int|null $placeId
	 * @param string $placeName
	 * @param string|null $webRegistrationQuestion1
	 * @param string|null $webRegistrationQuestion2
	 * @param string|null $webRegistrationQuestion3
	 * @param int|null $ageFrom
	 * @param int|null $ageUntil
	 * @param int|string|null $price
	 * @param bool $enableWebRegistration
	 * @param int|null $organizationalUnitId
	 * @param string|null $organizationalUnitName
	 * @param string|null $organizers
	 * @param string|null $contactPersonName
	 * @param string $contactPhone
	 * @param string $contactEmail
	 * @param string|null $contactWebsite
	 * @param string|null $invitationText
	 * @param string|null $workDescription
	 * @param string|null $meetingInformation
	 * @param string|null $responsiblePerson
	 * @param int|null $workingTime
	 * @param string|null $programDescription
	 * @param string|null $accommodation
	 * @param string|null $food
	 * @param string|null $notes
	 * @param string|null $mapLinkOrCoords
	 * @param string|null $attachment1
	 * @param string|null $attachment2
	 */
	public function __construct(
		$id,
		$name,
		\DateTimeImmutable $dateFrom,
		\DateTimeImmutable $dateUntil,
		$type,
		$programSlug = null,
		$programName = null,
		$placeId = null,
		$placeName,
		$webRegistrationQuestion1 = null,
		$webRegistrationQuestion2 = null,
		$webRegistrationQuestion3 = null,
		$ageFrom = null,
		$ageUntil = null,
		$price = null,
		$enableWebRegistration,
		$organizationalUnitId = null,
		$organizationalUnitName = null,
		$organizers = null,
		$contactPersonName = null,
		$contactPhone,
		$contactEmail,
		$contactWebsite = null,
		$invitationText = null,
		$workDescription = null,
		$meetingInformation = null,
		$responsiblePerson = null,
		$workingTime = null,
		$programDescription = null,
		$accommodation = null,
		$food = null,
		$notes = null,
		$mapLinkOrCoords = null,
		$attachment1 = null,
		$attachment2 = null
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
		$this->invitationText = $invitationText;
		$this->workDescription = $workDescription;
		$this->meetingInformation = $meetingInformation;
		$this->workingTime = $workingTime;
		$this->programDescription = $programDescription;
		$this->accommodation = $accommodation;
		$this->food = $food;
		$this->notes = $notes;


		// program

		if ($programSlug !== null && $programName !== null) {
			$this->program = Program::from($programSlug, $programName);
		}


		// web registration

		$this->enableWebRegistration = $enableWebRegistration;

		$this->webRegistrationQuestions = \array_map(function ($webRegistrationQuestion) { // And then turn the rest into objects.
			return RegistrationQuestion::from($webRegistrationQuestion);
		}, \array_filter([ // First exclude all null items.
			$webRegistrationQuestion1,
			$webRegistrationQuestion2,
			$webRegistrationQuestion3,
		], function ($v, $k) {
			return $v !== null;
		}, ARRAY_FILTER_USE_BOTH));


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


		// attachments

		if ($attachment1 !== null) {
			$this->attachments[] = $attachment1;
		}
		if ($attachment2 !== null) {
			$this->attachments[] = $attachment2;
		}
	}


	public static function fromResponseData(array $data)
	{
		$price = null;
		if ($data['poplatek'] !== '') {
			$price = $data['poplatek'];

			if (\preg_match('|^[0-9]+$|', $price)) {
				$price = (int) $price;
			}
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
			$data['add_info_title'] !== '' ? $data['add_info_title'] : null,
			$data['add_info_title_2'] !== '' ? $data['add_info_title_2'] : null,
			$data['add_info_title_3'] !== '' ? $data['add_info_title_3'] : null,
			$data['vek_od'] !== '' ? ((int) $data['vek_od']) : null,
			$data['vek_do'] !== '' ? ((int) $data['vek_do']) : null,
			$price,
			$data['prihlaska'] == 1, // intentionally ==
			$data['porada_id'] !== '' ? ((int)$data['porada_id']) : null,
			$data['porada'] !== '' ? $data['porada'] : null,
			$data['org'] !== '' ? $data['org'] : null,
			$data['kontakt'] !== '' ? $data['kontakt'] : null,
			$data['kontakt_telefon'],
			$data['kontakt_email'],
			$data['web'] !== '' ? $data['web'] : null,
			$data['text'] !== '' ? $data['text'] : null,
			$data['prace'] !== '' ? $data['prace'] : null,
			$data['sraz'] !== '' ? $data['sraz'] : null,
			$data['odpovedna'] !== '' ? $data['odpovedna'] : null,
			$data['pracovni_doba'] !== '' ? ((int) $data['pracovni_doba']) : null,
			$data['popis_programu'] !== '' ? $data['popis_programu'] : null,
			$data['ubytovani'] !== '' ? $data['ubytovani'] : null,
			$data['strava'] !== '' ? $data['strava'] : null,
			$data['jak_se_prihlasit'] !== '' ? $data['jak_se_prihlasit'] : null,
			$data['lokalita_mapa'] !== '' ? $data['lokalita_mapa'] : null,
			$data['priloha_1'] !== '' ? $data['priloha_1'] : null,
			$data['priloha_2'] !== '' ? $data['priloha_2'] : null
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
	 * @return bool
	 */
	public function isEnableWebRegistration()
	{
		return $this->enableWebRegistration;
	}

	/**
	 * @return RegistrationQuestion[]|array
	 */
	public function getWebRegistrationQuestions()
	{
		return $this->webRegistrationQuestions;
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
	 * @return int|string|null
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * @return Organizer
	 */
	public function getOrganizer()
	{
		return $this->organizer;
	}

	/**
	 * @return string|null
	 */
	public function getInvitationText()
	{
		return $this->invitationText;
	}

	/**
	 * @return string|null
	 */
	public function getWorkDescription()
	{
		return $this->workDescription;
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

	/**
	 * @return array
	 */
	public function getAttachments()
	{
		return $this->attachments;
	}

}
