<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisApiClient\Response\Event;

use HnutiBrontosaurus\BisApiClient\InvalidArgumentException;


final class TargetGroup
{

	const EVERYONE = 1;
	const ADULTS = 2;
	const CHILDREN = 3;
	const FAMILIES = 4;
	const FIRST_TIME_ATTENDEES = 5;


	/** @var int */
	private $id;


	/**
	 * @param int $id
	 */
	private function __construct($id)
	{
		if ( ! \in_array($id, [
			self::EVERYONE,
			self::ADULTS,
			self::CHILDREN,
			self::FAMILIES,
			self::FIRST_TIME_ATTENDEES,
		], true)) {
			throw new InvalidArgumentException('Value `' . $id . '` is not of valid types for `id` parameter.');
		}

		$this->id = $id;
	}

	/**
	 * @param int $id
	 * @return self
	 */
	public static function from($id)
	{
		return new self($id);
	}


	/**
	 * @return bool
	 */
	public function isOfTypeEveryone()
	{
		return $this->id === self::EVERYONE;
	}

	/**
	 * @return bool
	 */
	public function isOfTypeAdults()
	{
		return $this->id === self::ADULTS;
	}

	/**
	 * @return bool
	 */
	public function isOfTypeChildren()
	{
		return $this->id === self::CHILDREN;
	}

	/**
	 * @return bool
	 */
	public function isOfTypeFamilies()
	{
		return $this->id === self::FAMILIES;
	}

	/**
	 * @return bool
	 */
	public function isOfTypeFirstTimeAttendees()
	{
		return $this->id === self::FIRST_TIME_ATTENDEES;
	}

}
