<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisApiClient\Response\Event;

use HnutiBrontosaurus\BisApiClient\BadUsageException;
use HnutiBrontosaurus\BisApiClient\Response\Event\Invitation\Invitation;
use HnutiBrontosaurus\BisApiClient\Response\Event\Registration\RegistrationType;
use HnutiBrontosaurus\BisApiClient\Response\RegistrationTypeException;


final class Event
{

	private int $id;
	private string $name;
	private ?string $coverPhotoPath;
	private \DateTimeImmutable $dateFrom;
	private ?string $timeFrom;
	private \DateTimeImmutable $dateUntil;
	private string $type;
	private Program $program;
	private Place $place;
	private RegistrationType $registrationType;
	private ?int $ageFrom;
	private ?int $ageUntil;
	private int|string $price; // single number or interval
	private Organizer $organizer;
	private TargetGroup $targetGroup;
	private ?Invitation $invitation;
	private ?string $programDescription;
	private ?string $notes;
	private ?string $relatedWebsite;


	private function __construct(
		int $id,
		string $name,
		?string $coverPhotoPath,
		\DateTimeImmutable $dateFrom,
		\DateTimeImmutable $dateUntil,
		string $type,
		?string $programSlug,
		?string $programName,
		string $placeName,
		?string $placeAlternativeName,
		?string $placeCoordinates,
		int $registrationType,
		?string $webRegistrationQuestion1,
		?string $webRegistrationQuestion2,
		?string $webRegistrationQuestion3,
		?string $registrationCustomUrl,
		?int $ageFrom,
		?int $ageUntil,
		int|string $price,
		?int $organizationalUnitId,
		?string $organizationalUnitName,
		?string $organizers,
		?string $contactPersonName,
		string $contactPhone,
		string $contactEmail,
		int $targetGroupId,
		?string $invitationOrganizationalInformation,
		?string $invitationIntroduction,
		?string $invitationPresentationText,
		array $invitationPresentationPhotos,
		?string $invitationWorkDescription,
		?string $timeFrom,
		?string $responsiblePerson,
		?int $workHoursPerDay,
		?string $programDescription,
		?string $accommodation,
		?int $food,
		?string $notes,
		?string $relatedWebsite,
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
		$this->coverPhotoPath = $coverPhotoPath;


		// program

		$this->program = Program::from($programSlug, $programName);


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
		$this->targetGroup = TargetGroup::from($targetGroupId);


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

		$this->relatedWebsite = null;
		if ($relatedWebsite !== null) {
			if ( ! self::startsWith($relatedWebsite, 'http')) { // count with no protocol typed URLs
				$relatedWebsite = 'http://' . $relatedWebsite;
			}

			$this->relatedWebsite = $relatedWebsite;
		}
	}


	/**
	 * @param string[] $data Everything is string as it comes from HTTP response body.
	 * @throws RegistrationTypeException
	 * @throws BadUsageException
	 */
	public static function fromResponseData(array $data): static
	{
		$price = 0;
		if (isset($data['poplatek']) && $data['poplatek'] !== '') {
			$price = $data['poplatek'];

			if (\preg_match('|^[0-9]+$|', $price)) {
				$price = (int) $price;
			}
		}

		// BIS API returns "0", "1", "2" etc. for real options and "" when nothing is set
		$food = (isset($data['strava']) && $data['strava'] !== '') ? (int) $data['strava'] : null;

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
			(int) $data['id'],
			$data['nazev'],
			(isset($data['foto_hlavni']) && $data['foto_hlavni'] !== '') ? $data['foto_hlavni'] : null,
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
			(isset($data['porada_id']) && $data['porada_id'] !== '') ? ((int) $data['porada_id']) : null,
			(isset($data['porada']) && $data['porada'] !== '') ? $data['porada'] : null,
			(isset($data['org']) && $data['org'] !== '') ? $data['org'] : null,
			(isset($data['kontakt']) && $data['kontakt'] !== '') ? $data['kontakt'] : null,
			$data['kontakt_telefon'],
			$data['kontakt_email'],
			(int) $data['prokoho'],
			(isset($data['text_info']) && $data['text_info'] !== '') ? $data['text_info'] : null,
			(isset($data['text_uvod']) && $data['text_uvod'] !== '') ? $data['text_uvod'] : null,
			(isset($data['text_mnam']) && $data['text_mnam'] !== '') ? $data['text_mnam'] : null,
			$invitationPresentationPhotos,
			(isset($data['text_dobr']) && $data['text_dobr'] !== '') ? $data['text_dobr'] : null,
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


	public function getId(): int
	{
		return $this->id;
	}


	public function getCoverPhotoPath(): ?string
	{
		return $this->coverPhotoPath;
	}


	public function hasCoverPhoto(): bool
	{
		return $this->coverPhotoPath !== null;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getDateFrom(): \DateTimeImmutable
	{
		return $this->dateFrom;
	}


	public function getDateUntil(): \DateTimeImmutable
	{
		return $this->dateUntil;
	}


	public function getType(): string
	{
		return $this->type;
	}


	public function getProgram(): Program
	{
		return $this->program;
	}


	public function getPlace(): Place
	{
		return $this->place;
	}


	public function getRegistrationType(): RegistrationType
	{
		return $this->registrationType;
	}


	public function getAgeFrom(): ?int
	{
		return $this->ageFrom;
	}


	public function getAgeUntil(): ?int
	{
		return $this->ageUntil;
	}


	public function getPrice(): int|string
	{
		return $this->price;
	}


	public function isPaid(): bool
	{
		return $this->price !== 0;
	}


	public function getOrganizer(): Organizer
	{
		return $this->organizer;
	}


	public function getTargetGroup(): TargetGroup
	{
		return $this->targetGroup;
	}


	public function getInvitation(): ?Invitation
	{
		return $this->invitation;
	}


	public function hasTimeFrom(): bool
	{
		return $this->timeFrom !== null;
	}


	public function getTimeFrom(): ?string
	{
		return $this->timeFrom;
	}


	public function getProgramDescription(): ?string
	{
		return $this->programDescription;
	}


	public function getNotes(): ?string
	{
		return $this->notes;
	}


	public function hasRelatedWebsite(): bool
	{
		return $this->relatedWebsite !== null;
	}


	public function getRelatedWebsite(): ?string
	{
		return $this->relatedWebsite;
	}


	/**
	 * Extracted from \Nette\Utils\Strings (v2.3)
	 * Starts the $haystack string with the prefix $needle?
	 */
	private static function startsWith(string $haystack, string $needle): bool
	{
		return \strncmp($haystack, $needle, \strlen($needle)) === 0;
	}

}
