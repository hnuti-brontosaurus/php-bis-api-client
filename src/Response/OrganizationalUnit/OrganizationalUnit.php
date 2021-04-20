<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisApiClient\Response\OrganizationalUnit;


final class OrganizationalUnit
{

	const TYPE_CLUB = 1;
	const TYPE_BASE = 2;
	const TYPE_REGIONAL = 3;
	const TYPE_OFFICE = 4;


	private int $type;

	/**
	 * @throws UnknownOrganizationUnitTypeException
	 */
	private function __construct(
		private int $id,
		private string $name,
		private string $street,
		private string $city,
		private string $postCode,
		private ?string $phone,
		private ?string $email,
		private ?string $website,
		int $type,
		private ?string $chairman,
		private ?string $manager,
	) {

		if (!\in_array($type, [
			self::TYPE_CLUB,
			self::TYPE_BASE,
			self::TYPE_REGIONAL,
			self::TYPE_OFFICE,
		], true)) {
			throw new UnknownOrganizationUnitTypeException('Type `' . $type . '` is not of valid types.');
		}

		$this->type = $type;
	}


	/**
	 * @throws UnknownOrganizationUnitTypeException
	 */
	public static function fromResponseData(array $data): self
	{
		return new self(
			(int) $data['id'],
			$data['nazev'],
			$data['ulice'],
			$data['mesto'],
			$data['psc'],
			(isset($data['telefon']) && $data['telefon'] !== '') ? $data['telefon'] : null,
			(isset($data['email']) && $data['email'] !== '') ? $data['email'] : null,
			(isset($data['www']) && $data['www'] !== '') ? $data['www'] : null,
			(int) $data['uroven'],
			(isset($data['predseda']) && $data['predseda'] !== '') ? $data['predseda'] : null,
			(isset($data['hospodar']) && $data['hospodar'] !== '') ? $data['hospodar'] : null,
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


	public function getStreet(): string
	{
		return $this->street;
	}


	public function getCity(): string
	{
		return $this->city;
	}


	public function getPostCode(): string
	{
		return $this->postCode;
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
		return $this->type === self::TYPE_CLUB;
	}


	public function isBaseUnit(): bool
	{
		return $this->type === self::TYPE_BASE;
	}


	public function isRegionalUnit(): bool
	{
		return $this->type === self::TYPE_REGIONAL;
	}


	public function isOffice(): bool
	{
		return $this->type === self::TYPE_OFFICE;
	}

}
