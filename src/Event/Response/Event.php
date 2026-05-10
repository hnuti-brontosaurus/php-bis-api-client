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
use function reset;


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
	 *     tags: array<array{
	 *         id: int,
	 *         name: string,
	 *         slug: string,
	 *         description: string,
	 *         is_active: bool,
	 *     }>,
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
		$cover = reset($data['propagation']['images']);
		return new self(
			$data['id'],
			$data['name'],
			$cover ? Image::from($cover['image']) : null,
			DateTimeImmutable::createFromFormat('Y-m-d', $data['start']),
			$data['start_time'] !== null ? $data['start_time'] : null,
			DateTimeImmutable::createFromFormat('Y-m-d', $data['end']),
			$data['duration'],
			Location::from(
				$data['location']['name'],
				$data['location']['gps_location'] !== null
					? Coordinates::from($data['location']['gps_location']['coordinates'][1], $data['location']['gps_location']['coordinates'][0])
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
					$data['propagation']['contact_email'] !== null ? $data['propagation']['contact_email'] : '', // todo temp unless BIS returns nulls for some old events
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
