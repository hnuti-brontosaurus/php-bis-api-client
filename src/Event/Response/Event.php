<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Response;

use Brick\DateTime\LocalDate;
use Brick\DateTime\LocalTime;
use HnutiBrontosaurus\BisClient\Event\Category;
use HnutiBrontosaurus\BisClient\Event\Group;
use HnutiBrontosaurus\BisClient\Event\IntendedFor;
use HnutiBrontosaurus\BisClient\Event\Program;
use HnutiBrontosaurus\BisClient\Response\ContactPerson;
use HnutiBrontosaurus\BisClient\Response\Coordinates;
use HnutiBrontosaurus\BisClient\Response\Location;


final class Event
{

	/**
	 * @param string[] $administrationUnits
	 * @param Photo[] $photos
	 * @param array<mixed> $rawData
	 */
	private function __construct(
		private int $id,
		private string $name,
		private ?Photo $coverPhotoPath,
		private LocalDate $startDate,
		private ?LocalTime $startTime,
		private LocalDate $endDate,
		private int $duration,
		private Location $location,
		private Group $group,
		private Category $category,
		private Program $program,
		private IntendedFor $intendedFor,
		private array $administrationUnits,
		private Propagation $propagation,
		private Registration $registration,
		private array $photos,
		private array $rawData,
	) {}


	/**
	 * @param array{
	 *     id: int,
	 *     name: string,
	 *     start: string,
	 *     start_time: string|null,
	 *     end: string,
	 *     duration: int,
	 *     location: array{
	 *         name: string,
	 *         description: string,
	 *         patron: null,
	 *         program: array{id: int, name: string, slug: string}|null,
	 *         accessibility_from_prague: array{id: int, name: string, slug: string}|null,
	 *         accessibility_from_brno: array{id: int, name: string, slug: string}|null,
	 *         volunteering_work: string,
	 *         volunteering_work_done: string,
	 *         volunteering_work_goals: string,
	 *         options_around: string,
	 *         facilities: string,
	 *         web: string,
	 *         address: string,
	 *         gps_location: array{type: string, coordinates: array{0: float, 1: float}}|null,
	 *         region: string|null,
	 *         photos: array<array{small: string, medium: string, large: string, original: string}>,
	 *     },
	 *     group: array{
	 *         id: int,
	 *         name: string,
	 *         slug: string,
	 *     },
	 *     category: array{
	 *         id: int,
	 *         name: string,
	 *         slug: string,
	 *     },
	 *     program: array{
	 *         id: int,
	 *         name: string,
	 *         slug: string,
	 *     },
	 *     intended_for: array{
	 *         id: int,
	 *         name: string,
	 *         slug: string,
	 *     },
	 *     administration_units: string[],
	 *     propagation: array{
	 *         minimum_age: int|null,
	 *         maximum_age:int|null,
	 *         cost: string,
	 *         intended_for: array{id: int, name: string, slug: string},
	 *         accommodation: string,
	 *         working_days: int|null,
	 *         working_hours: int|null,
	 *         diets: array<array{id: int, name: string, slug: 'vege'|'meat'|'vegan'}>,
	 *         organizers: string,
	 *         web_url: string,
	 *         invitation_text_introduction: string,
	 *         invitation_text_practical_information: string,
	 *         invitation_text_work_description: string,
	 *         invitation_text_about_us: string,
	 *         contact_name: string|null,
	 *         contact_phone: string|null,
	 *         contact_email: string,
	 *         images: array<array{image: array{small: string, medium: string, large: string, original: string}}>,
	 *     },
	 *     registration: array{
	 *         is_registration_required: bool,
	 *         is_event_full: bool,
	 *     },
	 * } $data
	 */
	public static function fromResponseData(array $data): self
	{
		$photos = \array_map(
			static fn($photo) => Photo::from($photo['image']),
			$data['propagation']['images'],
		);
		$mainPhoto = \array_shift($photos);

		return new self(
			$data['id'],
			$data['name'],
			$mainPhoto,
			LocalDate::parse($data['start']),
			$data['start_time'] !== null ? LocalTime::parse($data['start_time']) : null,
			LocalDate::parse($data['end']),
			$data['duration'],
			Location::from(
				$data['location']['name'],
				$data['location']['gps_location'] !== null
					? Coordinates::from($data['location']['gps_location']['coordinates'][1], $data['location']['gps_location']['coordinates'][0])
					: null,
			),
			Group::fromScalar($data['group']['slug']),
			Category::fromScalar($data['category']['slug']),
			Program::fromScalar($data['program']['slug']),
			IntendedFor::fromScalar($data['intended_for']['slug']),
			$data['administration_units'],
			Propagation::from(
				$data['propagation']['minimum_age'],
				$data['propagation']['maximum_age'],
				$data['propagation']['cost'],
				$data['propagation']['accommodation'] !== '' ? $data['propagation']['accommodation'] : null,
				$data['propagation']['working_days'],
				$data['propagation']['working_hours'],
				\array_map(static fn($diet) => Diet::fromScalar($diet['slug']), $data['propagation']['diets']),
				$data['propagation']['organizers'] !== '' ? $data['propagation']['organizers'] : null,
				$data['propagation']['web_url'] !== '' ? $data['propagation']['web_url'] : null,
				$data['propagation']['invitation_text_introduction'],
				$data['propagation']['invitation_text_practical_information'],
				$data['propagation']['invitation_text_work_description'] !== '' ? $data['propagation']['invitation_text_work_description'] : null,
				$data['propagation']['invitation_text_about_us'] !== '' ? $data['propagation']['invitation_text_about_us'] : null,
				ContactPerson::from(
					$data['propagation']['contact_name'] !== null ? $data['propagation']['contact_name'] : null,
					$data['propagation']['contact_email'] !== null ? $data['propagation']['contact_email'] : '', // todo temp unless BIS returns nulls for some old events
					$data['propagation']['contact_phone'] !== null && $data['propagation']['contact_phone'] !== '' ? $data['propagation']['contact_phone'] : null,
				),
				\array_map(
					static fn($photo) => Image::from($photo['image']),
					$data['propagation']['images'],
				),
			),
			Registration::from(
				$data['registration']['is_registration_required'],
				$data['registration']['is_event_full'],
			),
			$photos,
			$data,
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


	public function getStartDate(): LocalDate
	{
		return $this->startDate;
	}


	public function getStartTime(): ?LocalTime
	{
		return $this->startTime;
	}


	public function getEndDate(): LocalDate
	{
		return $this->endDate;
	}


	public function getDuration(): int
	{
		return $this->duration;
	}


	public function getLocation(): Location
	{
		return $this->location;
	}


	public function getGroup(): Group
	{
		return $this->group;
	}


	public function getCategory(): Category
	{
		return $this->category;
	}


	public function getProgram(): Program
	{
		return $this->program;
	}


	public function getIntendedFor(): IntendedFor
	{
		return $this->intendedFor;
	}

	/** @deprecated use getIntendedFor() instead */
	public function getTargetGroup(): IntendedFor
	{
		return $this->getIntendedFor();
	}


	/**
	 * @return string[]
	 */
	public function getAdministrationUnits(): array
	{
		return $this->administrationUnits;
	}


	public function getPropagation(): Propagation
	{
		return $this->propagation;
	}


	public function getRegistration(): Registration
	{
		return $this->registration;
	}


	/**
	 * In case that methods provided by this client are not enough.
	 * See fromResponseData() or consult BIS API docs for detailed array description.
	 * @return array<mixed>
	 */
	public function getRawData(): array
	{
		return $this->rawData;
	}


	// DEPRECATED METHODS

	/** @deprecated use getRegistration()->getIsRegistrationRequired() */
	public function getIsRegistrationRequired(): bool
	{
		return $this->getRegistration()->getIsRegistrationRequired();
	}

	/** @deprecated use getRegistration()->getIsEventFull() */
	public function getIsFull(): bool
	{
		return $this->getRegistration()->getIsEventFull();
	}

	/** @deprecated use getPropagation()->getMinimumAge() instead */
	public function getAgeFrom(): ?int
	{
		return $this->getPropagation()->getMinimumAge();
	}

	/** @deprecated use getPropagation()->getMaximumAge() instead */
	public function getAgeUntil(): ?int
	{
		return $this->getPropagation()->getMaximumAge();
	}

	/** @deprecated use getPropagation()->getCost() instead */
	public function getPrice(): string
	{
		return $this->getPropagation()->getCost();
	}

	/** @deprecated use getPropagation()->getOrganizers() instead */
	public function getOrganizers(): ?string
	{
		return $this->getPropagation()->getOrganizers();
	}

	/** @deprecated use getPropagation()->getContactPerson() instead */
	public function getContactPerson(): ContactPerson
	{
		return $this->getPropagation()->getContactPerson();
	}

	/** @deprecated use getPropagation()->getInvitationTextIntroduction() instead */
	public function getIntroduction(): string
	{
		return $this->getPropagation()->getInvitationTextIntroduction();
	}

	/** @deprecated use getPropagation()->getInvitationTextPracticalInformation() instead */
	public function getPracticalInformation(): string
	{
		return $this->getPropagation()->getInvitationTextPracticalInformation();
	}

	/** @deprecated use getPropagation()->getAccommodation() instead */
	public function getAccommodation(): ?string
	{
		return $this->getPropagation()->getAccommodation();
	}

	/**
	 * @deprecated use getPropagation()->getDiets() instead
	 * @return Food[]
	 */
	public function getFood(): array
	{
		return \array_map(
			static fn(Diet $diet): Food => Food::fromScalar($diet->toScalar()),
			$this->getPropagation()->getDiets(),
		);
	}

	/** @deprecated use getPropagation()->getInvitationTextWorkDescription() instead */
	public function getWorkDescription(): ?string
	{
		return $this->getPropagation()->getInvitationTextWorkDescription();
	}

	/** @deprecated use getPropagation()->getWorkingDays() instead */
	public function getWorkDays(): ?int
	{
		return $this->getPropagation()->getWorkingDays();
	}

	/** @deprecated use getPropagation()->getWorkingHours() instead */
	public function getWorkHoursPerDay(): ?int
	{
		return $this->getPropagation()->getWorkingHours();
	}

	/** @deprecated use getPropagation()->getInvitationTextAboutUs() instead */
	public function getAboutUs(): ?string
	{
		return $this->getPropagation()->getInvitationTextAboutUs();
	}

	/** @deprecated use getPropagation()->getWebUrl() instead */
	public function getRelatedWebsite(): ?string
	{
		return $this->getPropagation()->getWebUrl();
	}

	/**
	 * Returns all photos except for the first one which is accessible with getCoverPhotoPath()
	 * @deprecated use getPropagation()->getImages() instead which return all images and don't exclude the first one
	 * @return Photo[]
	 */
	public function getPhotos(): array
	{
		return $this->photos;
	}

}
