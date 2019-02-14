<?php

namespace HnutiBrontosaurus\BisApiClient\Response\Event;

use HnutiBrontosaurus\BisApiClient\BisClientException;


final class TargetGroup
{

	const UNKNOWN = 0;
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
			self::UNKNOWN,
			self::EVERYONE,
			self::ADULTS,
			self::CHILDREN,
			self::FAMILIES,
			self::FIRST_TIME_ATTENDEES,
		], true)) {
			$id = self::UNKNOWN; // silent fallback
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
	 * @return self
	 */
	public static function unknown()
	{
		return new self(self::UNKNOWN);
	}


	/**
	 * @return bool
	 */
	public function isOfUnknownType()
	{
		return $this->id === self::UNKNOWN;
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
