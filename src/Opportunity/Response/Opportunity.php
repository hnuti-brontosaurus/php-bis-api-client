<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Opportunity\Response;

use Brick\DateTime\LocalDate;
use HnutiBrontosaurus\BisClient\Opportunity\Category;
use HnutiBrontosaurus\BisClient\Response\ContactPerson;
use HnutiBrontosaurus\BisClient\Response\Coordinates;
use HnutiBrontosaurus\BisClient\Response\Html;
use HnutiBrontosaurus\BisClient\Response\Image;
use HnutiBrontosaurus\BisClient\Response\Location;


final class Opportunity
{

	/**
	 * @param array<mixed> $rawData
	 */
	private function __construct(
		private int $id,
		private string $name,
		private Category $category,
		private LocalDate $startDate,
		private LocalDate $endDate,
		private Location $location,
		private Html $introduction,
		private Html $description,
		private ?Html $locationBenefits,
		private Html $personalBenefits,
		private Html $requirements,
		private ContactPerson $contactPerson,
		private Image $image,
		private array $rawData,
	) {}

	/**
	 * @param array{
	 *     id: int,
	 *     category: array{
	 *         id: int,
	 *         name: string,
	 *         description: string,
	 *         slug: string,
	 *     },
	 *     name: string,
	 *     start: string,
	 *     end: string,
	 *     on_web_start: string,
	 *     on_web_end: string,
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
	 *     introduction: string,
	 *     description: string,
	 *     location_benefits: string,
	 *     personal_benefits: string,
	 *     requirements: string,
	 *     contact_name: string,
	 *     contact_phone: string,
	 *     contact_email: string,
	 *     image: array{small: string, medium: string, large: string, original: string},
	 * } $data
	 */
	public static function fromResponseData(array $data): self
	{
		return new self(
			$data['id'],
			$data['name'],
			Category::fromScalar($data['category']['slug']),
			LocalDate::parse($data['start']),
			LocalDate::parse($data['end']),
			Location::from($data['location']['name'], $data['location']['gps_location'] !== null
				? Coordinates::from(
					$data['location']['gps_location']['coordinates'][1],
					$data['location']['gps_location']['coordinates'][0],
				)
				: null),
			Html::of($data['introduction']),
			Html::of($data['description']),
			$data['location_benefits'] !== '' ? Html::of($data['location_benefits']) : null,
			Html::of($data['personal_benefits']),
			Html::of($data['requirements']),
			ContactPerson::from(
				$data['contact_name'],
				$data['contact_email'],
				$data['contact_phone'] !== '' ? $data['contact_phone'] : null,
			),
			Image::from((array) $data['image']),
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


	public function getCategory(): Category
	{
		return $this->category;
	}


	public function getStartDate(): LocalDate
	{
		return $this->startDate;
	}


	public function getEndDate(): LocalDate
	{
		return $this->endDate;
	}


	public function getLocation(): Location
	{
		return $this->location;
	}


	public function getIntroduction(): Html
	{
		return $this->introduction;
	}


	public function getDescription(): Html
	{
		return $this->description;
	}


	public function getLocationBenefits(): ?Html
	{
		return $this->locationBenefits;
	}


	public function getPersonalBenefits(): Html
	{
		return $this->personalBenefits;
	}


	public function getRequirements(): Html
	{
		return $this->requirements;
	}


	public function getContactPerson(): ContactPerson
	{
		return $this->contactPerson;
	}


	public function getImage(): Image
	{
		return $this->image;
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
