<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\AdministrationUnit\Response;

use HnutiBrontosaurus\BisClient\Response\Coordinates;
use function str_starts_with;


final readonly class SubUnit
{

	/**
	 * @param string[]|null $subLeaders
	 * @param array<mixed> $rawData
	 */
	private function __construct(
		public int $id,
		public string $name,
		public ?string $description,
		public bool $isForKids,
		public ?string $phone,
		public ?string $email,
		public ?string $website,
		public ?string $address,
		public Coordinates $coordinates,
		public ?string $mainLeader,
		public ?array $subLeaders,
		private array $rawData,
	) {}


	/**
	 * @param array{
	 *     id: int,
	 *     name: string,
	 *     description: string,
	 *     is_for_kids: bool,
	 *     is_active: bool,
	 *     phone: string,
	 *     email: string,
	 *     www: string,
	 *     facebook: string,
	 *     instagram: string,
	 *     address: string,
	 *     gps_location: array{
	 *         type: string,
	 *         coordinates: array{0: float, 1: float}
	 *     },
	 *     main_leader: array{id: int, name: string, email: string, phone: string}|null,
	 *     sub_leaders: array<array{id: int, name: string, email: string, phone: string}>|null,
	 * } $data
	 */
	public static function fromResponseData(array $data): self
	{
		return new self(
			$data['id'],
			$data['name'],
			$data['description'] !== '' ? $data['description'] : null,
			$data['is_for_kids'],
			$data['phone'] !== '' ? $data['phone'] : null,
			$data['email'] !== '' ? $data['email'] : null,
			$data['www'] !== '' ? self::fixUrl($data['www']) : null,
			$data['address'] !== '' ? $data['address'] : null,
			Coordinates::from(
				$data['gps_location']['coordinates'][1],
				$data['gps_location']['coordinates'][0],
			),
			$data['main_leader'] !== null ? $data['main_leader']['name'] : null,
			$data['sub_leaders'] !== null ? array_map(fn($leader) => $leader['name'], $data['sub_leaders']) : null,
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
