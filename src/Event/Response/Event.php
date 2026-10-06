<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Response;

use DateTimeImmutable;
use DateTimeInterface;
use HnutiBrontosaurus\BisClient\Event\Category;
use HnutiBrontosaurus\BisClient\Event\Group;
use HnutiBrontosaurus\BisClient\Event\IntendedFor;
use HnutiBrontosaurus\BisClient\Event\Program;
use HnutiBrontosaurus\BisClient\Response\ContactPerson;
use HnutiBrontosaurus\BisClient\Response\Coordinates;
use HnutiBrontosaurus\BisClient\Response\Image;
use HnutiBrontosaurus\BisClient\Response\Location;
use function array_map;
use function array_first;
use function assert;


final readonly class Event
{

	/**
	 * @param Tag[] $tags
	 * @param string[] $administrationUnits
	 * @param array<mixed> $rawData
	 */
	private function __construct(
		public int $id,
		public string $name,
		public ?Image $coverPhotoPath,
		public DateTimeInterface $startDate,
		public ?string $startTime,
		public DateTimeInterface $endDate,
		public int $duration,
		public Location $location,
		public Group $group,
		public Category $category,
		public array $tags,
		public Program $program,
		public IntendedFor $intendedFor,
		public array $administrationUnits,
		public Propagation $propagation,
		public Registration $registration,
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
	 *         gps_location?: array{type: string, coordinates: array{0: float, 1: float}}|null,
	 *     },
	 *     group: array{
	 *         slug: string,
	 *     },
	 *     category: array{
	 *         slug: string,
	 *     },
	 *     tags: list<array{
	 *         id: int,
	 *         name: string,
	 *         slug: string,
	 *         description: string,
	 *         is_active: bool,
	 *     }>,
	 *     program: array{
	 *         slug: string,
	 *     },
	 *     intended_for: array{
	 *         slug: string,
	 *     },
	 *     administration_units: string[],
	 *     propagation: array{
	 *         minimum_age: int|null,
	 *         maximum_age: int|null,
	 *         cost: string,
	 *         accommodation: string,
	 *         working_days: int|null,
	 *         working_hours: int|null,
	 *         diets: list<array{id: int, name: string, slug: 'vege'|'meat'|'vegan'}>,
	 *         organizers: string,
	 *         web_url: string,
	 *         invitation_text_introduction: string,
	 *         invitation_text_practical_information: string,
	 *         invitation_text_work_description: string,
	 *         invitation_text_about_us: string,
	 *         contact_name: string|null,
	 *         contact_phone: string|null,
	 *         contact_email: string,
	 *         images: list<array{image: array{small: string, medium: string, large: string, original: string}}>,
	 *     },
	 *     registration?: array{
	 *         is_registration_required?: bool,
	 *         is_event_full?: bool,
	 *     }|null,
	 * } $data
	 */
	public static function fromResponseData(array $data): self
	{
		$cover = array_first($data['propagation']['images']);

		$startDate = DateTimeImmutable::createFromFormat('Y-m-d', $data['start']);
		assert($startDate !== false);
		$endDate = DateTimeImmutable::createFromFormat('Y-m-d', $data['end']);
		assert($endDate !== false);

		$locationGps = $data['location']['gps_location'] ?? null;

		return new self(
			$data['id'],
			$data['name'],
			$cover ? Image::from($cover['image']) : null,
			$startDate,
			($data['start_time'] ?? null) !== null ? $data['start_time'] : null,
			$endDate,
			$data['duration'],
			Location::from(
				$data['location']['name'],
				$locationGps !== null
					? Coordinates::from($locationGps['coordinates'][1], $locationGps['coordinates'][0])
					: null,
			),
			Group::from($data['group']['slug']),
			Category::bcCompatibleFrom($data['category']['slug']),
			array_map(static fn(array $tag) => Tag::fromPayload($tag), $data['tags']),
			Program::from($data['program']['slug']),
			IntendedFor::from($data['intended_for']['slug']),
			$data['administration_units'],
			Propagation::from(
				$data['propagation']['minimum_age'],
				$data['propagation']['maximum_age'],
				$data['propagation']['cost'],
				$data['propagation']['accommodation'] !== '' ? $data['propagation']['accommodation'] : null,
				$data['propagation']['working_days'],
				$data['propagation']['working_hours'],
				array_map(static fn($diet) => Diet::from($diet['slug']), $data['propagation']['diets']),
				$data['propagation']['organizers'] !== '' ? $data['propagation']['organizers'] : null,
				$data['propagation']['web_url'] !== '' ? $data['propagation']['web_url'] : null,
				$data['propagation']['invitation_text_introduction'],
				$data['propagation']['invitation_text_practical_information'],
				$data['propagation']['invitation_text_work_description'] !== '' ? $data['propagation']['invitation_text_work_description'] : null,
				$data['propagation']['invitation_text_about_us'] !== '' ? $data['propagation']['invitation_text_about_us'] : null,
				ContactPerson::from(
					$data['propagation']['contact_name'] !== null ? $data['propagation']['contact_name'] : null,
					$data['propagation']['contact_email'],
					$data['propagation']['contact_phone'] !== null && $data['propagation']['contact_phone'] !== '' ? $data['propagation']['contact_phone'] : null,
				),
				array_map(
					static fn($photo) => Image::from($photo['image']),
					$data['propagation']['images'],
				),
			),
			Registration::from(
			/**
			 * Currently, administration unit chairmen can access BIS backend and remove there registration object data
			 * by mistake which then lead $data['registration'] being null. To prevent it, we set default values.
			 */
				$data['registration']['is_registration_required'] ?? false,
				$data['registration']['is_event_full'] ?? false,
			),
			$data,
		);
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
