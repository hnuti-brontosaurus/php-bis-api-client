<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Opportunity\Response;

use DateTimeImmutable;
use DateTimeInterface;
use HnutiBrontosaurus\BisClient\Opportunity\Category;
use HnutiBrontosaurus\BisClient\Response\ContactPerson;
use HnutiBrontosaurus\BisClient\Response\Coordinates;
use HnutiBrontosaurus\BisClient\Response\Html;
use HnutiBrontosaurus\BisClient\Response\Image;
use HnutiBrontosaurus\BisClient\Response\Location;


final readonly class Opportunity
{

	/**
	 * @param array<mixed> $rawData
	 */
	private function __construct(
		public int $id,
		public string $name,
		public Category $category,
		public DateTimeInterface $startDate,
		public DateTimeInterface $endDate,
		public Location $location,
		public Html $introduction,
		public Html $description,
		public ?Html $locationBenefits,
		public Html $personalBenefits,
		public Html $requirements,
		public ContactPerson $contactPerson,
		public Image $image,
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
			Category::from($data['category']['slug']),
			DateTimeImmutable::createFromFormat('Y-m-d', $data['start']),
			DateTimeImmutable::createFromFormat('Y-m-d', $data['end']),
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
