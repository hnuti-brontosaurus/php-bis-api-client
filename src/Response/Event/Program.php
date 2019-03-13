<?php

namespace HnutiBrontosaurus\BisApiClient\Response\Event;

use HnutiBrontosaurus\BisApiClient\InvalidArgumentException;


final class Program
{

	const PROGRAM_NONE = 'none';
	const PROGRAM_NATURE = 'ap';
	const PROGRAM_SIGHTS = 'pamatky';
	const PROGRAM_BRDO = 'brdo';
	const PROGRAM_EKOSTAN = 'ekostan';
	const PROGRAM_PSB = 'psb';
	const PROGRAM_EDUCATION = 'vzdelavani';


	/** @var string */
	private $slug;

	/** @var string */
	private $name;


	/**
	 * @param string $slug
	 * @param string $name
	 * @throws InvalidArgumentException
	 */
	private function __construct($slug, $name)
	{
		if (!\in_array($slug, [
			self::PROGRAM_NONE,
			self::PROGRAM_NATURE,
			self::PROGRAM_SIGHTS,
			self::PROGRAM_BRDO,
			self::PROGRAM_EKOSTAN,
			self::PROGRAM_PSB,
			self::PROGRAM_EDUCATION,
		], true)) {
			throw new InvalidArgumentException('Value `' . $slug . '` is not of valid types for `slug` parameter.');
		}

		$this->slug = $slug;
		$this->name = $name;
	}

	/**
	 * @param string $slug
	 * @param string $name
	 * @return self
	 */
	public static function from($slug, $name)
	{
		return new self($slug, $name);
	}


	/**
	 * @return string
	 */
	public function getSlug()
	{
		return $this->slug;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}


	/**
	 * @return bool
	 */
	public function isOfTypeNature()
	{
		return $this->slug === self::PROGRAM_NATURE;
	}

	/**
	 * @return bool
	 */
	public function isOfTypeSights()
	{
		return $this->slug === self::PROGRAM_SIGHTS;
	}

	/**
	 * @return bool
	 */
	public function isOfTypeHoliday()
	{
		return $this->slug === self::PROGRAM_PSB;
	}

}
