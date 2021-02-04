<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisApiClient\Response\OrganizationalUnit;


final class OrganizationalUnit
{

	const TYPE_CLUB = 1;
	const TYPE_BASE = 2;
	const TYPE_REGIONAL = 3;
	const TYPE_OFFICE = 4;


	/** @var int */
	private $id;

	/** @var string */
	private $name;

	/** @var string */
	private $street;

	/** @var string */
	private $city;

	/** @var string */
	private $postCode;

	/** @var string|null */
	private $phone;

	/** @var string|null */
	private $email;

	/** @var string|null */
	private $website;

	/** @var int */
	private $type;

	/** @var string|null */
	private $chairman;

	/** @var string|null */
	private $manager;


	/**
	 * @param int $id
	 * @param string $name
	 * @param string $street
	 * @param string $city
	 * @param string $postCode
	 * @param string|null $phone
	 * @param string|null $email
	 * @param string|null $website
	 * @param int $type
	 * @param string|null $chairman
	 * @param string|null $manager
	 */
	private function __construct(
		$id,
		$name,
		$street,
		$city,
		$postCode,
		$phone = null,
		$email = null,
		$website = null,
		$type,
		$chairman = null,
		$manager = null
	) {
		$this->id = $id;
		$this->name = $name;
		$this->street = $street;
		$this->city = $city;
		$this->postCode = $postCode;
		$this->phone = $phone;
		$this->email = $email;
		$this->website = $website;
		$this->chairman = $chairman;
		$this->manager = $manager;

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


	public static function fromResponseData(array $data)
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
			(isset($data['hospodar']) && $data['hospodar'] !== '') ? $data['hospodar'] : null
		);
	}


	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getStreet()
	{
		return $this->street;
	}

	/**
	 * @return string
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * @return string
	 */
	public function getPostCode()
	{
		return $this->postCode;
	}

	/**
	 * @return string|null
	 */
	public function getPhone()
	{
		return $this->phone;
	}

	/**
	 * @return string|null
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @return string|null
	 */
	public function getWebsite()
	{
		return $this->website;
	}

	/**
	 * @return int
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @return string|null
	 */
	public function getChairman()
	{
		return $this->chairman;
	}

	/**
	 * @return string|null
	 */
	public function getManager()
	{
		return $this->manager;
	}


	/**
	 * @return bool
	 */
	public function isClub()
	{
		return $this->type === self::TYPE_CLUB;
	}

	/**
	 * @return bool
	 */
	public function isBaseUnit()
	{
		return $this->type === self::TYPE_BASE;
	}

	/**
	 * @return bool
	 */
	public function isRegionalUnit()
	{
		return $this->type === self::TYPE_REGIONAL;
	}

	/**
	 * @return bool
	 */
	public function isOffice()
	{
		return $this->type === self::TYPE_OFFICE;
	}

}
