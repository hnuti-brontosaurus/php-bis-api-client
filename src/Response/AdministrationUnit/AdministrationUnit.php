<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response\AdministrationUnit;

use HnutiBrontosaurus\BisClient\Enums\AdministrationUnitCategory;
use HnutiBrontosaurus\BisClient\Response\Coordinates;


final class AdministrationUnit
{

	private function __construct(
		private int $id,
		private string $name,
		private bool $isForKids,
		private string $address,
		private ?Coordinates $coordinates,
		private ?string $phone,
		private ?string $email,
		private ?string $website,
		private AdministrationUnitCategory $category,
		private ?string $chairman,
		private ?string $manager,
	) {}


	/**
	 * @param array{
	 *     id: int,
	 *     name: string,
	 *     abbreviation: string,
	 *     is_for_kids: bool,
	 *     phone: string,
	 *     email: string,
	 *     www: string,
	 *     ic: string,
	 *     address: string,
	 *     contact_address: null,
	 *     bank_account_number: string,
	 *     existed_since: string|null,
	 *     existed_till: string|null,
	 *     category: array{
	 *         id: int,
	 *         name: string,
	 *         slug: string,
	 *	   },
	 *     chairman: array{id: int, name: string, email: string, phone: string}|null,
	 *     vice_chairman: array{id: int, name: string, email: string, phone: string}|null,
	 *     manager: array{id: int, name: string, email: string, phone: string}|null,
	 *     board_members: array<array{id: int, name: string, email: string, phone: string}>,
	 * } $data
	 */
	public static function fromResponseData(array $data): self
	{
		return new self(
			$data['id'],
			$data['name'],
			$data['is_for_kids'],
			$data['address'],
			$data['gps_latitude'] !== null && $data['gps_longitude'] !== null
				? Coordinates::from($data['gps_latitude'], $data['gps_longitude'])
				: null,
			$data['phone'] !== '' ? $data['phone'] : null,
			$data['email'] !== '' ? $data['email'] : null,
			$data['www'] !== '' ? $data['www'] : null,
			AdministrationUnitCategory::fromScalar($data['category']['slug']),
			$data['chairman'] !== null ? $data['chairman']['name'] : null,
			$data['manager'] !== null ? $data['manager']['name'] : null,
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


	public function getIsForKids(): bool
	{
		return $this->isForKids;
	}


	public function getAddress(): string
	{
		return $this->address;
	}


	public function getCoordinates(): ?Coordinates
	{
		return $this->coordinates;
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


	public function getChairman(): ?string
	{
		return $this->chairman;
	}


	public function getManager(): ?string
	{
		return $this->manager;
	}


	public function isClub(): bool
	{
		return $this->category->equals(AdministrationUnitCategory::CLUB());
	}


	public function isBaseUnit(): bool
	{
		return $this->category->equals(AdministrationUnitCategory::BASIC_SECTION());
	}


	public function isRegionalUnit(): bool
	{
		return $this->category->equals(AdministrationUnitCategory::REGIONAL_CENTER());
	}


	public function isOffice(): bool
	{
		return $this->category->equals(AdministrationUnitCategory::HEADQUARTER());
	}

}
