<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\Event;

use HnutiBrontosaurus\BisClient\Enums\Program;
use HnutiBrontosaurus\BisClient\Enums\TargetGroup;
use HnutiBrontosaurus\BisClient\Response\Coordinates;
use HnutiBrontosaurus\BisClient\Response\Event\Invitation\Food;
use HnutiBrontosaurus\BisClient\Response\Event\Invitation\Invitation;
use HnutiBrontosaurus\BisClient\Response\Event\Invitation\Photo;
use HnutiBrontosaurus\BisClient\Response\Event\Invitation\Presentation;
use HnutiBrontosaurus\BisClient\Response\Event\Registration\RegistrationQuestion;
use HnutiBrontosaurus\BisClient\Response\Event\Registration\RegistrationType;
use HnutiBrontosaurus\BisClient\Response\Event\Registration\RegistrationTypeEnum;


final class Event
{

	private function __construct(
		private int $id,
		private string $name,
		private ?Photo $coverPhotoPath,
		private \DateTimeImmutable $dateFrom,
		private \DateTimeImmutable $dateUntil,
		private Program $program,
		private Place $place,
		private RegistrationType $registrationType,
		private ?int $ageFrom,
		private ?int $ageUntil,
		private ?string $price, // todo: single number or interval
		private ?string $organizers,
		private ContactPerson $contactPerson,
		private TargetGroup $targetGroup,
		private Invitation $invitation,
		private ?string $relatedWebsite,
	) {}


	public static function fromResponseData(\stdClass $data): self
	{
		// registration
		$contactEmail = $data->propagation->contact_email;
		$data->entry_form_url = '';
		$registrationCustomUrl = $data->entry_form_url;
		$registrationQuestions = \array_filter([], fn($v, $k) => $v !== '', \ARRAY_FILTER_USE_BOTH); // todo remove
		$registrationType = RegistrationType::from(
//			RegistrationTypeEnum::fromScalar($data->registration_method),
			RegistrationTypeEnum::BRONTOWEB(), // todo
			\array_map(fn(string $question) => RegistrationQuestion::from($question), $registrationQuestions),
			$contactEmail,
			$registrationCustomUrl,
		);


		// invitation

		$photos = \array_map(
			static fn($photo) => Photo::from((array) $photo),
			$data->propagation->images,
		);
		$mainPhoto = \array_shift($photos);

		$invitationPresentationText = $data->propagation->invitation_text_about_us;
		$invitation = Invitation::from(
			$data->propagation->invitation_text_introduction,
			$data->propagation->invitation_text_practical_information,
			$data->propagation->accommodation,
			\array_map(static fn($diet) => Food::fromScalar($diet->slug), $data->propagation->diets),
			$data->propagation->invitation_text_work_description,
//			$data->working_hours,
			2,
			($invitationPresentationText !== null || \count($photos) > 0)
				? Presentation::from($invitationPresentationText, $photos)
				: null,
		);


		// related website
		$relatedWebsite = $data->propagation->web_url;
		$_relatedWebsite = null;
		if ($relatedWebsite !== '') {
			if ( ! self::startsWith($relatedWebsite, 'http')) { // count with no protocol typed URLs
				$relatedWebsite = 'http://' . $relatedWebsite;
			}

			$_relatedWebsite = $relatedWebsite;
		}

		return new self(
			$data->id,
			$data->name,
			$mainPhoto,
			new \DateTimeImmutable($data->start),
			\DateTimeImmutable::createFromFormat('Y-m-d', $data->end),
			Program::fromScalar($data->program->slug),
			$data->location->gps_location === null
				? Place::from('nezadáno', null) // todo temp, until there are nullable locations coming from API
				: Place::from(
				$data->location->name,
				$data->location->gps_location->latitude !== null && $data->location->gps_location->longitude !== null
					? Coordinates::from($data->location->gps_location->latitude, $data->location->gps_location->longitude)
					: null,
			),
			$registrationType,
			$data->propagation->minimum_age,
			$data->propagation->maximum_age,
			$data->propagation->cost !== null ? $data->propagation->cost : null,
			$data->propagation->organizers !== '' ? $data->propagation->organizers : null,
			ContactPerson::from(
				$data->propagation->contact_name,
				$contactEmail,
				$data->propagation->contact_phone,
			),
			TargetGroup::fromScalar($data->propagation->intended_for->slug),
			$invitation,
			$_relatedWebsite,
		);
	}


	public function getId(): int
	{
		return $this->id;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getCoverPhotoPath(): ?Photo
	{
		return $this->coverPhotoPath;
	}


	public function getDateFrom(): \DateTimeImmutable
	{
		return $this->dateFrom;
	}


	public function getDateUntil(): \DateTimeImmutable
	{
		return $this->dateUntil;
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


	public function getPrice(): ?string
	{
		return $this->price;
	}


	public function getOrganizers(): ?string
	{
		return $this->organizers;
	}


	public function getContactPerson(): ContactPerson
	{
		return $this->contactPerson;
	}


	public function getTargetGroup(): TargetGroup
	{
		return $this->targetGroup;
	}


	public function getInvitation(): Invitation
	{
		return $this->invitation;
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
