<?php

namespace HnutiBrontosaurus\BisApiClient\Response;


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

	/** @var Program|NULL */
	private $program;

	/** @var Place */
	private $place;

	/** @var bool */
	private $enableWebRegistration = FALSE;

	/** @var RegistrationQuestion[]|array */
	private $webRegistrationQuestions = [];

	/** @var int|NULL */
	private $ageFrom;

	/** @var int|NULL */
	private $ageUntil;

	/**
	 * Single number, interval or null.
	 * @var int|string|null
	 */
	private $price;

	/** @var Organizer */
	private $organizer;

	/** @var string|NULL */
	private $invitationText;

	/** @var string|NULL */
	private $workDescription;

	/** @var string|NULL */
	private $meetingInformation;

	/** @var int|NULL */
	private $workingTime;

	/** @var string|NULL */
	private $programDescription;

	/** @var string|NULL */
	private $accommodation;

	/** @var string|NULL */
	private $food;

	/** @var string|NULL */
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
	 * @param string|NULL $programSlug
	 * @param string|NULL $programName
	 * @param int|NULL $placeId
	 * @param string $placeName
	 * @param string|NULL $webRegistrationQuestion1
	 * @param string|NULL $webRegistrationQuestion2
	 * @param string|NULL $webRegistrationQuestion3
	 * @param int|NULL $ageFrom
	 * @param int|NULL $ageUntil
	 * @param int|string|NULL $price
	 * @param bool $enableWebRegistration
	 * @param int|NULL $organizationalUnitId
	 * @param string|NULL $organizationalUnitName
	 * @param string|NULL $organizers
	 * @param string|NULL $contactPersonName
	 * @param string $contactPhone
	 * @param string $contactEmail
	 * @param string|NULL $contactWebsite
	 * @param string|NULL $invitationText
	 * @param string|NULL $workDescription
	 * @param string|NULL $meetingInformation
	 * @param string|NULL $responsiblePerson
	 * @param int|NULL $workingTime
	 * @param string|NULL $programDescription
	 * @param string|NULL $accommodation
	 * @param string|NULL $food
	 * @param string|NULL $notes
	 * @param string|NULL $mapLinkOrCoords
	 * @param string|NULL $attachment1
	 * @param string|NULL $attachment2
	 */
	public function __construct(
		$id,
		$name,
		\DateTimeImmutable $dateFrom,
		\DateTimeImmutable $dateUntil,
		$type,
		$programSlug = NULL,
		$programName = NULL,
		$placeId = NULL,
		$placeName,
		$webRegistrationQuestion1 = NULL,
		$webRegistrationQuestion2 = NULL,
		$webRegistrationQuestion3 = NULL,
		$ageFrom = NULL,
		$ageUntil = NULL,
		$price = NULL,
		$enableWebRegistration,
		$organizationalUnitId = NULL,
		$organizationalUnitName = NULL,
		$organizers = NULL,
		$contactPersonName = NULL,
		$contactPhone,
		$contactEmail,
		$contactWebsite = NULL,
		$invitationText = NULL,
		$workDescription = NULL,
		$meetingInformation = NULL,
		$responsiblePerson = NULL,
		$workingTime = NULL,
		$programDescription = NULL,
		$accommodation = NULL,
		$food = NULL,
		$notes = NULL,
		$mapLinkOrCoords = NULL,
		$attachment1 = NULL,
		$attachment2 = NULL
	) {
		$this->id = $id;
		$this->name = $name;
		$this->dateFrom = $dateFrom;
		$this->dateUntil = $dateUntil;
		$this->type = $type;
		$this->place = new Place($placeId, $placeName, $mapLinkOrCoords);
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

		if ($programSlug !== NULL && $programName !== NULL) {
			$this->program = new Program($programSlug, $programName);
		}


		// web registration

		$this->enableWebRegistration = $enableWebRegistration;

		$this->webRegistrationQuestions = \array_map(function ($webRegistrationQuestion) { // And then turn the rest into objects.
			return new RegistrationQuestion($webRegistrationQuestion);
		}, \array_filter([ // First exclude all null items.
			$webRegistrationQuestion1,
			$webRegistrationQuestion2,
			$webRegistrationQuestion3,
		], function ($v, $k) {
			return $v !== NULL;
		}, ARRAY_FILTER_USE_BOTH));


		// organizers

		$this->organizer = new Organizer(
			($organizationalUnitId !== NULL && $organizationalUnitName !== NULL) ? new OrganizerOrganizationalUnit($organizationalUnitId, $organizationalUnitName) : NULL,
			$responsiblePerson,
			$organizers,
			$contactPersonName,
			$contactPhone,
			$contactEmail,
			$contactWebsite
		);


		// attachments

		if ($attachment1 !== NULL) {
			$this->attachments[] = $attachment1;
		}
		if ($attachment2 !== NULL) {
			$this->attachments[] = $attachment2;
		}
	}


	public static function fromResponseData(array $data)
	{
		$price = NULL;
		if ($data['poplatek'] !== '') {
			$price = $data['poplatek'];

			if (\preg_match('|^[0-9]+$|', $price)) {
				$price = (int)$price;
			}
		}

		return new self(
			(int)$data['id'],
			$data['nazev'],
			\DateTimeImmutable::createFromFormat('Y-m-d', $data['od']),
			\DateTimeImmutable::createFromFormat('Y-m-d', $data['do']),
			$data['typ'],
			$data['program_id'] !== '' ? $data['program_id'] : NULL,
			$data['program'] !== '' ? $data['program'] : NULL,
			$data['lokalita_id'] !== '' ? ((int)$data['lokalita_id']) : NULL,
			$data['lokalita'],
			$data['add_info_title'] !== '' ? $data['add_info_title'] : NULL,
			$data['add_info_title_2'] !== '' ? $data['add_info_title_2'] : NULL,
			$data['add_info_title_3'] !== '' ? $data['add_info_title_3'] : NULL,
			$data['vek_od'] !== '' ? ((int)$data['vek_od']) : NULL,
			$data['vek_do'] !== '' ? ((int)$data['vek_do']) : NULL,
			$price,
			$data['prihlaska'] == 1, // intentionally ==
			$data['porada_id'] !== '' ? ((int)$data['porada_id']) : NULL,
			$data['porada'] !== '' ? $data['porada'] : NULL,
			$data['org'] !== '' ? $data['org'] : NULL,
			$data['kontakt'] !== '' ? $data['kontakt'] : NULL,
			$data['kontakt_telefon'],
			$data['kontakt_email'],
			$data['web'] !== '' ? $data['web'] : NULL,
			$data['text'] !== '' ? $data['text'] : NULL,
			$data['prace'] !== '' ? $data['prace'] : NULL,
			$data['sraz'] !== '' ? $data['sraz'] : NULL,
			$data['odpovedna'] !== '' ? $data['odpovedna'] : NULL,
			$data['pracovni_doba'] !== '' ? ((int)$data['pracovni_doba']) : NULL,
			$data['popis_programu'] !== '' ? $data['popis_programu'] : NULL,
			$data['ubytovani'] !== '' ? $data['ubytovani'] : NULL,
			$data['strava'] !== '' ? $data['strava'] : NULL,
			$data['jak_se_prihlasit'] !== '' ? $data['jak_se_prihlasit'] : NULL,
			$data['lokalita_mapa'] !== '' ? $data['lokalita_mapa'] : NULL,
			$data['priloha_1'] !== '' ? $data['priloha_1'] : NULL,
			$data['priloha_2'] !== '' ? $data['priloha_2'] : NULL
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
	 * @return Program|NULL
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
	 * @return int|NULL
	 */
	public function getAgeFrom()
	{
		return $this->ageFrom;
	}

	/**
	 * @return int|NULL
	 */
	public function getAgeUntil()
	{
		return $this->ageUntil;
	}

	/**
	 * @return int|string|NULL
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
	 * @return string|NULL
	 */
	public function getInvitationText()
	{
		return $this->invitationText;
	}

	/**
	 * @return string|NULL
	 */
	public function getWorkDescription()
	{
		return $this->workDescription;
	}

	/**
	 * @return string|NULL
	 */
	public function getMeetingInformation()
	{
		return $this->meetingInformation;
	}

	/**
	 * @return int|NULL
	 */
	public function getWorkingTime()
	{
		return $this->workingTime;
	}

	/**
	 * @return string|NULL
	 */
	public function getProgramDescription()
	{
		return $this->programDescription;
	}

	/**
	 * @return string|NULL
	 */
	public function getAccommodation()
	{
		return $this->accommodation;
	}

	/**
	 * @return string|NULL
	 */
	public function getFood()
	{
		return $this->food;
	}

	/**
	 * @return string|NULL
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
