<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\Event;

use HnutiBrontosaurus\BisClient\Enums\IntendedFor;
use HnutiBrontosaurus\BisClient\Enums\Program;
use HnutiBrontosaurus\BisClient\Response\ContactPerson;
use HnutiBrontosaurus\BisClient\Response\Coordinates;
use HnutiBrontosaurus\BisClient\Response\Location;
use HnutiBrontosaurus\BisClient\RuntimeException;


final class Event
{

	/**
	 * @param string[] $administrationUnits
	 * @param Food[] $food
	 * @param Photo[] $photos
	 * @param array<mixed> $rawData
	 */
	private function __construct(
		private int $id,
		private string $name,
		private ?Photo $coverPhotoPath,
		private \DateTimeImmutable $dateFrom,
		private \DateTimeImmutable $dateUntil,
		private Program $program,
		private Location $location,
		private bool $isRegistrationRequired,
		private bool $isFull,
		private ?int $ageFrom,
		private ?int $ageUntil,
		private ?string $price,
		private ?string $organizers,
		private array $administrationUnits,
		private ContactPerson $contactPerson,
		private IntendedFor $targetGroup,
		private string $introduction,
		private string $practicalInformation,
		private string $accommodation,
		private array $food,
		private ?string $workDescription,
		private ?int $workDays,
		private ?int $workHoursPerDay,
		private ?string $aboutUs,
		private array $photos,
		private ?string $relatedWebsite,
		private array $rawData,
	) {}


	/**
	 * @param array{
	 *     id: int,
	 *     name: string,
	 *     start: string,
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
	 *         cost: string|null,
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

		$endDate = \DateTimeImmutable::createFromFormat('Y-m-d', $data['end']);
		if ($endDate === false) throw new RuntimeException(\sprintf("Unexpected format of end date '%s'", $data['start']));

		return new self(
			$data['id'],
			$data['name'],
			$mainPhoto,
			new \DateTimeImmutable($data['start']),
			$endDate,
			Program::fromScalar($data['program']['slug']),
			Location::from(
				$data['location']['name'],
				$data['location']['gps_location'] !== null
					? Coordinates::from($data['location']['gps_location']['coordinates'][1], $data['location']['gps_location']['coordinates'][0])
					: null,
			),
			$data['registration']['is_registration_required'],
			$data['registration']['is_event_full'],
			$data['propagation']['minimum_age'],
			$data['propagation']['maximum_age'],
			$data['propagation']['cost'] !== null ? $data['propagation']['cost'] : null,
			$data['propagation']['organizers'] !== '' ? $data['propagation']['organizers'] : null,
			$data['administration_units'],
			ContactPerson::from(
				$data['propagation']['contact_name'] !== null ? $data['propagation']['contact_name'] : null,
				$data['propagation']['contact_email'],
				$data['propagation']['contact_phone'] !== null && $data['propagation']['contact_phone'] !== '' ? $data['propagation']['contact_phone'] : null,
			),
			IntendedFor::fromScalar($data['intended_for']['slug']),
			$data['propagation']['invitation_text_introduction'],
			$data['propagation']['invitation_text_practical_information'],
			$data['propagation']['accommodation'],
			\array_map(static fn($diet) => Food::fromScalar($diet['slug']), $data['propagation']['diets']),
			$data['propagation']['invitation_text_work_description'] !== '' ? $data['propagation']['invitation_text_work_description'] : null,
			$data['propagation']['working_days'],
			$data['propagation']['working_hours'],
			$data['propagation']['invitation_text_about_us'] !== '' ? $data['propagation']['invitation_text_about_us'] : null,
			$photos,
			$data['propagation']['web_url'] !== '' ? $data['propagation']['web_url'] : null,
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


	public function getLocation(): Location
	{
		return $this->location;
	}


	public function getIsRegistrationRequired(): bool
	{
		return $this->isRegistrationRequired;
	}


	public function getIsFull(): bool
	{
		return $this->isFull;
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


	/**
	 * @return string[]
	 */
	public function getAdministrationUnits(): array
	{
		return $this->administrationUnits;
	}


	public function getContactPerson(): ContactPerson
	{
		return $this->contactPerson;
	}


	public function getTargetGroup(): IntendedFor
	{
		return $this->targetGroup;
	}


	public function getIntroduction(): string
	{
		return $this->introduction;
	}


	public function getPracticalInformation(): string
	{
		return $this->practicalInformation;
	}


	public function getAccommodation(): string
	{
		return $this->accommodation;
	}


	/**
	 * @return Food[]
	 */
	public function getFood(): array
	{
		return $this->food;
	}


	public function getWorkDescription(): ?string
	{
		return $this->workDescription;
	}


	public function getWorkDays(): ?int
	{
		return $this->workDays;
	}


	public function getWorkHoursPerDay(): ?int
	{
		return $this->workHoursPerDay;
	}


	public function getAboutUs(): ?string
	{
		return $this->aboutUs;
	}


	/**
	 * @return Photo[]
	 */
	public function getPhotos(): array
	{
		return $this->photos;
	}


	public function getRelatedWebsite(): ?string
	{
		return $this->relatedWebsite;
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

}
