<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\AdministrationUnit\Response;

use HnutiBrontosaurus\BisClient\Response\Coordinates;
use function str_starts_with;


final class SubUnit
{

	/**
	 * @param array<mixed> $rawData
	 */
	private function __construct(
		private int $id,
		private string $name,
		private ?string $description,
		private bool $isForKids,
		private bool $isActive,
		private ?string $phone,
		private ?string $email,
		private ?string $website,
		private ?string $address,
		private ?Coordinates $coordinates,
		private ?string $mainLeader,
		private array $subLeaders,
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
	 *     main_leader: array{id: int, name: string, email: string, phone: string},
	 *     sub_leaders: array<array{id: int, name: string, email: string, phone: string}>,
	 * } $data
	 */
	public static function fromResponseData(array $data): self
	{
		return new self(
			$data['id'],
			$data['name'],
			$data['description'] !== '' ? $data['description'] : null,
			$data['is_for_kids'],
			$data['is_active'],
			$data['phone'] !== '' ? $data['phone'] : null,
			$data['email'] !== '' ? $data['email'] : null,
			$data['www'] !== '' ? self::fixUrl($data['www']) : null,
			$data['address'] !== '' ? $data['address'] : null,
			$data['gps_location'] !== null
				? Coordinates::from(
					$data['gps_location']['coordinates'][1],
					$data['gps_location']['coordinates'][0],
				)
				: null,
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


	public function getId(): int
	{
		return $this->id;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getDescription(): ?string
	{
		return $this->description;
	}

	public function isForKids(): bool
	{
		return $this->isForKids;
	}

	public function isActive(): bool
	{
		return $this->isActive;
	}

	public function getPhone(): ?string
	{
		return $this->phone;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function getWebsite(): ?string
	{
		return $this->website;
	}

	public function getAddress(): ?string
	{
		return $this->address;
	}

	public function getCoordinates(): ?Coordinates
	{
		return $this->coordinates;
	}

	public function getMainLeader(): ?string
	{
		return $this->mainLeader;
	}

	public function getSubLeaders(): array
	{
		return $this->subLeaders;
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
