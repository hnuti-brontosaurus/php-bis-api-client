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

	/** @var string|null */
	private $name;


	/**
	 * @param string|null $slug
	 * @param string|null $name
	 * @throws InvalidArgumentException
	 */
	private function __construct($slug = null, $name = null)
	{
		if ($slug === null) {
			$slug = self::PROGRAM_NONE;
		}

		if ( ! \in_array($slug, [
			self::PROGRAM_NONE,
			self::PROGRAM_NATURE,
			self::PROGRAM_SIGHTS,
			self::PROGRAM_BRDO,
			self::PROGRAM_EKOSTAN,
			self::PROGRAM_PSB,
			self::PROGRAM_EDUCATION,
		], true)) {
			$slug = self::PROGRAM_NONE;
		}

		$this->slug = $slug;

		if ($name !== null) {
			$this->name = $name;
		}
	}

	/**
	 * @param string|null $slug
	 * @param string|null $name
	 * @return self
	 */
	public static function from($slug = null, $name = null)
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
	public function isNotSelected()
	{
		return $this->slug === self::PROGRAM_NONE;
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
	public function isOfTypeBrdo()
	{
		return $this->slug === self::PROGRAM_BRDO;
	}

	/**
	 * @return bool
	 */
	public function isOfTypeEkostan()
	{
		return $this->slug === self::PROGRAM_EKOSTAN;
	}

	/**
	 * @return bool
	 */
	public function isOfTypePsb()
	{
		return $this->slug === self::PROGRAM_PSB;
	}

	/**
	 * @return bool
	 */
	public function isOfTypeEducation()
	{
		return $this->slug === self::PROGRAM_EDUCATION;
	}

}
