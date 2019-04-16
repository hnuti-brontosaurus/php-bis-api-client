<?php

namespace HnutiBrontosaurus\BisApiClient\Response\Event;

use HnutiBrontosaurus\BisApiClient\BadUsageException;
use HnutiBrontosaurus\BisApiClient\InvalidArgumentException;
use HnutiBrontosaurus\BisApiClient\Response\Event\Invitation\Invitation;
use HnutiBrontosaurus\BisApiClient\Response\Event\Registration\RegistrationType;
use HnutiBrontosaurus\BisApiClient\Response\RegistrationTypeException;


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

	/** @var string|null */
	private $timeFrom;

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

	/** @var TargetGroup */
	private $targetGroup;

	/** @var Invitation|null */
	private $invitation;

	/** @var string|null */
	private $programDescription;

	/** @var string|null */
	private $notes;

	/** @var string|null */
	private $relatedWebsite;


	/**
	 * @param int $id
	 * @param string $name
	 * @param string|null $coverPhotoPath
	 * @param \DateTimeImmutable $dateFrom
	 * @param \DateTimeImmutable $dateUntil
	 * @param string $type
	 * @param string|null $programSlug
	 * @param string|null $programName
	 * @param string $placeName
	 * @param string|null $placeAlternativeName
	 * @param string|null $placeCoordinates
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
	 * @param int|null $targetGroupId
	 * @param string|null $invitationOrganizationalInformation
	 * @param string|null $invitationIntroduction
	 * @param string|null $invitationPresentationText
	 * @param array $invitationPresentationPhotos
	 * @param string|null $invitationWorkDescription
	 * @param string|null $timeFrom
	 * @param string|null $responsiblePerson
	 * @param int|null $workHoursPerDay
	 * @param string|null $programDescription
	 * @param string|null $accommodation
	 * @param string|null $food
	 * @param string|null $notes
	 * @param string|null $relatedWebsite
	 * @throws RegistrationTypeException
	 * @throws BadUsageException
	 */
	private function __construct(
		$id,
		$name,
		$coverPhotoPath = null,
		\DateTimeImmutable $dateFrom,
		\DateTimeImmutable $dateUntil,
		$type,
		$programSlug = null,
		$programName = null,
		$placeName,
		$placeAlternativeName = null,
		$placeCoordinates = null,
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
		$targetGroupId = null,
		$invitationOrganizationalInformation = null,
		$invitationIntroduction = null,
		$invitationPresentationText = null,
		array $invitationPresentationPhotos = [],
		$invitationWorkDescription = null,
		$timeFrom = null,
		$responsiblePerson = null,
		$workHoursPerDay = null,
		$programDescription = null,
		$accommodation = null,
		$food = null,
		$notes = null,
		$relatedWebsite = null
	) {
		$this->id = $id;
		$this->name = $name;
		$this->dateFrom = $dateFrom;
		$this->dateUntil = $dateUntil;
		$this->type = $type;
		$this->place = Place::from($placeName, $placeAlternativeName, $placeCoordinates);
		$this->ageFrom = $ageFrom;
		$this->ageUntil = $ageUntil;
		$this->price = $price;
		$this->timeFrom = $timeFrom;
		$this->programDescription = $programDescription;
		$this->notes = $notes;


		// cover photo

		if ($coverPhotoPath !== null) {
			$this->coverPhotoPath = $coverPhotoPath;
		}


		// program

		if ($programSlug !== null && $programName !== null) {
			try {
				$this->program = Program::from($programSlug, $programName);

			} catch (InvalidArgumentException $e) {
				// if exception, program remains null

			}
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
			$contactEmail
		);


		// target group
		$this->targetGroup = $targetGroupId !== null ? TargetGroup::from($targetGroupId) : TargetGroup::unknown();


		// invitation

		$this->invitation = Invitation::from(
			$invitationIntroduction,
			$invitationOrganizationalInformation,
			$accommodation,
			$food,
			$invitationWorkDescription,
			$workHoursPerDay,
			$invitationPresentationText,
			$invitationPresentationPhotos
		);


		// related website

		if ($relatedWebsite !== null) {
			if ( ! self::startsWith($relatedWebsite, 'http')) { // count with no protocol typed URLs
				$relatedWebsite = 'http://' . $relatedWebsite;
			}

			$this->relatedWebsite = $relatedWebsite;
		}
	}


	/**
	 * @param string[] $data Everything is string as it comes from HTTP response body.
	 * @return self
	 * @throws RegistrationTypeException
	 * @throws BadUsageException
	 */
	public static function fromResponseData(array $data)
	{
		$price = 0;
		if (isset($data['poplatek']) && $data['poplatek'] !== '') {
			$price = $data['poplatek'];

			if (\preg_match('|^[0-9]+$|', $price)) {
				$price = (int) $price;
			}
		}

		$food = (isset($data['strava']) && $data['strava'] !== '') ? $data['strava'] : null;
		if ($food === 'můžete si vybrat') { // BIS API sends this string in case that user sets nothing - we want to get rid of it as it pretends to be a value when it is not
			$food = null;
		}

		$invitationPresentationPhotos = [];
		if (isset($data['ochutnavka_1']) && $data['ochutnavka_1'] !== '') {
			$invitationPresentationPhotos[] = $data['ochutnavka_1'];
		}
		if (isset($data['ochutnavka_2']) && $data['ochutnavka_2'] !== '') {
			$invitationPresentationPhotos[] = $data['ochutnavka_2'];
		}
		if (isset($data['ochutnavka_3']) && $data['ochutnavka_3'] !== '') {
			$invitationPresentationPhotos[] = $data['ochutnavka_3'];
		}
		if (isset($data['ochutnavka_4']) && $data['ochutnavka_4'] !== '') {
			$invitationPresentationPhotos[] = $data['ochutnavka_4'];
		}
		if (isset($data['ochutnavka_5']) && $data['ochutnavka_5'] !== '') {
			$invitationPresentationPhotos[] = $data['ochutnavka_5'];
		}
		if (isset($data['ochutnavka_6']) && $data['ochutnavka_6'] !== '') {
			$invitationPresentationPhotos[] = $data['ochutnavka_6'];
		}

		return new self(
			(int)$data['id'],
			$data['nazev'],
			(isset($data['priloha_1']) && $data['priloha_1'] !== '') ? $data['priloha_1'] : null,
			\DateTimeImmutable::createFromFormat('Y-m-d', $data['od']),
			\DateTimeImmutable::createFromFormat('Y-m-d', $data['do']),
			$data['typ'],
			(isset($data['program_id']) && $data['program_id'] !== '') ? $data['program_id'] : null,
			(isset($data['program']) && $data['program'] !== '') ? $data['program'] : null,
			$data['lokalita'],
			(isset($data['lokalita_misto']) && $data['lokalita_misto'] !== '') ? $data['lokalita_misto'] : null,
			(isset($data['lokalita_gps']) && $data['lokalita_gps'] !== '') ? $data['lokalita_gps'] : null,
			(int) $data['prihlaska'],
			(isset($data['add_info_title']) && $data['add_info_title'] !== '') ? $data['add_info_title'] : null,
			(isset($data['add_info_title_2']) && $data['add_info_title_2'] !== '') ? $data['add_info_title_2'] : null,
			(isset($data['add_info_title_3']) && $data['add_info_title_3'] !== '') ? $data['add_info_title_3'] : null,
			(isset($data['kontakt_url']) && $data['kontakt_url'] !== '') ? $data['kontakt_url'] : null,
			(isset($data['vek_od']) && $data['vek_od'] !== '') ? ((int) $data['vek_od']) : null,
			(isset($data['vek_do']) && $data['vek_do'] !== '') ? ((int) $data['vek_do']) : null,
			$price,
			(isset($data['porada_id']) && $data['porada_id'] !== '') ? ((int)$data['porada_id']) : null,
			(isset($data['porada']) && $data['porada'] !== '') ? $data['porada'] : null,
			(isset($data['org']) && $data['org'] !== '') ? $data['org'] : null,
			(isset($data['kontakt']) && $data['kontakt'] !== '') ? $data['kontakt'] : null,
			$data['kontakt_telefon'],
			$data['kontakt_email'],
			(isset($data['prokoho_id']) && $data['prokoho_id'] !== '') ? ((int) $data['prokoho_id']) : null,
			(isset($data['text_info']) && $data['text_info'] !== '') ? $data['text_info'] : null,
			(isset($data['text_uvod']) && $data['text_uvod'] !== '') ? $data['text_uvod'] : null,
			(isset($data['text_mnam']) && $data['text_mnam'] !== '') ? $data['text_mnam'] : null,
			$invitationPresentationPhotos,
			(isset($data['prace']) && $data['prace'] !== '') ? $data['prace'] : null,
			(isset($data['sraz']) && $data['sraz'] !== '') ? $data['sraz'] : null,
			(isset($data['odpovedna']) && $data['odpovedna'] !== '') ? $data['odpovedna'] : null,
			(isset($data['pracovni_doba']) && $data['pracovni_doba'] !== '') ? ((int) $data['pracovni_doba']) : null,
			(isset($data['popis_programu']) && $data['popis_programu'] !== '') ? $data['popis_programu'] : null,
			(isset($data['ubytovani']) && $data['ubytovani'] !== '') ? $data['ubytovani'] : null,
			$food,
			(isset($data['jak_se_prihlasit']) && $data['jak_se_prihlasit'] !== '') ? $data['jak_se_prihlasit'] : null,
			(isset($data['web']) && $data['web'] !== '') ? $data['web'] : null
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
	 * @return TargetGroup
	 */
	public function getTargetGroup()
	{
		return $this->targetGroup;
	}

	/**
	 * @return Invitation|null
	 */
	public function getInvitation()
	{
		return $this->invitation;
	}

	/**
	 * @return bool
	 */
	public function hasTimeFrom()
	{
		return $this->timeFrom !== null;
	}

	/**
	 * @return string|null
	 */
	public function getTimeFrom()
	{
		return $this->timeFrom;
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
	public function getNotes()
	{
		return $this->notes;
	}

	/**
	 * @return bool
	 */
	public function hasRelatedWebsite()
	{
		return $this->relatedWebsite !== null;
	}

	/**
	 * @return string|null
	 */
	public function getRelatedWebsite()
	{
		return $this->relatedWebsite;
	}


	/**
	 * Extracted from \Nette\Utils\Strings (v2.3)
	 * Starts the $haystack string with the prefix $needle?
	 * @param  string
	 * @param  string
	 * @return bool
	 */
	private static function startsWith($haystack, $needle)
	{
		return strncmp($haystack, $needle, strlen($needle)) === 0;
	}

}
