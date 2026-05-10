<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\AdministrationUnit\Response;

use HnutiBrontosaurus\BisClient\AdministrationUnit\Category;
use HnutiBrontosaurus\BisClient\Response\Coordinates;
use HnutiBrontosaurus\BisClient\Response\Image;
use function str_starts_with;


final readonly class AdministrationUnit
{

	/**
	 * @param array<SubUnit> $subUnits
	 * @param array<mixed> $rawData
	 */
	private function __construct(
		public int $id,
		public string $name,
		public ?string $description,
		public ?Image $image,
		public bool $isForKids,
		public ?string $address,
		public Coordinates $coordinates,
		public ?string $phone,
		public ?string $email,
		public ?string $website,
		public Category $category,
		public ?string $chairman,
		public ?string $manager,
		public array $subUnits,
		private array $rawData,
	) {}


	/**
	 * @param array{
	 *     id: int,
	 *     name: string,
	 *     abbreviation: string,
	 *     description: string,
	 *     image: array{small: string, medium: string, large: string, original: string}|null,
	 *     is_for_kids: bool,
	 *     phone: string,
	 *     email: string,
	 *     www: string,
	 *     facebook: string,
	 *     instagram: string,
	 *     ic: string,
	 *     address: string,
	 *     contact_address: string,
	 *     bank_account_number: string,
	 *     existed_since: string|null,
	 *     existed_till: string|null,
	 *     gps_location: array{
	 *         type: string,
	 *         coordinates: array{0: float, 1: float},
	 *     },
	 *     category: array{
	 *         id: int,
	 *         name: string,
	 *         slug: string,
	 *     },
	 *     chairman: array{id: int, name: string, email: string, phone: string}|null,
	 *     vice_chairman: array{id: int, name: string, email: string, phone: string}|null,
	 *     manager: array{id: int, name: string, email: string, phone: string}|null,
	 *     board_members: array<array{id: int, name: string, email: string, phone: string}>,
	 *     sub_units: array<array{
	 *         id: int,
	 *         name: string,
	 *         description: string,
	 *         is_for_kids: bool,
	 *         is_active: bool,
	 *         phone: string,
	 *         email: string,
	 *         www: string,
	 *         facebook: string,
	 *         instagram: string,
	 *         address: string,
	 *         gps_location: array{
	 *             type: string,
	 *             coordinates: array{0: float, 1: float}
	 *         },
	 *         main_leader: array{id: int, name: string, email: string, phone: string},
	 *         sub_leaders: array<array{id: int, name: string, email: string, phone: string}>,
	 *     }>
	 * } $data
	 */
	public static function fromResponseData(array $data): self
	{
		$subUnits = array_filter($data['sub_units'], fn($subUnit) => $subUnit['is_active']);
		$subUnits = array_map(fn($subUnitData) => SubUnit::fromResponseData($subUnitData), $subUnits);

		return new self(
			$data['id'],
			$data['name'],
			$data['description'] !== '' ? $data['description'] : null,
			$data['image'] !== null ? Image::from($data['image']) : null,
			$data['is_for_kids'],
			$data['address'] !== '' ? $data['address'] : null,
			Coordinates::from(
				$data['gps_location']['coordinates'][1],
				$data['gps_location']['coordinates'][0],
			),
			$data['phone'] !== '' ? $data['phone'] : null,
			$data['email'] !== '' ? $data['email'] : null,
			$data['www'] !== '' ? self::fixUrl($data['www']) : null,
			Category::from($data['category']['slug']),
			$data['chairman'] !== null ? $data['chairman']['name'] : null,
			$data['manager'] !== null ? $data['manager']['name'] : null,
			$subUnits,
			$data,
		);
	}

	private static function fixUrl(string $url): string
	{
		if (str_starts_with($url, 'http')) {
			return $url;
		}

		return 'http://' . $url;
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
