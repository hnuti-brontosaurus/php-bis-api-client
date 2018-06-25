<?php

namespace HnutiBrontosaurus\BisApiClient\Response;

use HnutiBrontosaurus\BisApiClient\InvalidArgumentException;


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

	/** @var string|NULL */
	private $phone;

	/** @var string|NULL */
	private $email;

	/** @var string|NULL */
	private $website;

	/** @var int */
	private $type;

	/** @var string|NULL */
	private $chairman;

	/** @var string|NULL */
	private $manager;


	/**
	 * @param int $id
	 * @param string $name
	 * @param string $street
	 * @param string $city
	 * @param string $postCode
	 * @param string|NULL $phone
	 * @param string|NULL $email
	 * @param string|NULL $website
	 * @param int $type
	 * @param string|NULL $chairman
	 * @param string|NULL $manager
	 */
	public function __construct(
		$id,
		$name,
		$street,
		$city,
		$postCode,
		$phone = NULL,
		$email = NULL,
		$website = NULL,
		$type,
		$chairman = NULL,
		$manager = NULL
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
		], TRUE)) {
			throw new InvalidArgumentException('Type `' . $type . '` is not of valid types.');
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
			$data['telefon'] !== '' ? $data['telefon'] : NULL,
			$data['email'] !== '' ? $data['email'] : NULL,
			$data['www'] !== '' ? $data['www'] : NULL,
			(int) $data['uroven'],
			$data['predseda'] !== '' ? $data['predseda'] : NULL,
			$data['hospodar'] !== '' ? $data['hospodar'] : NULL
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
	 * @return string|NULL
	 */
	public function getPhone()
	{
		return $this->phone;
	}

	/**
	 * @return string|NULL
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @return string|NULL
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
	 * @return string|NULL
	 */
	public function getChairman()
	{
		return $this->chairman;
	}

	/**
	 * @return string|NULL
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
