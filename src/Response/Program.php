<?php

namespace HnutiBrontosaurus\BisApiClient\Response;

use HnutiBrontosaurus\BisApiClient\InvalidArgumentException;


final class Program
{

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
	 */
	public function __construct($slug, $name)
	{
		if (!\in_array($slug, [
			self::PROGRAM_NATURE,
			self::PROGRAM_SIGHTS,
			self::PROGRAM_BRDO,
			self::PROGRAM_EKOSTAN,
			self::PROGRAM_PSB,
			self::PROGRAM_EDUCATION,
		])) {
			throw new InvalidArgumentException('Value `' . $slug . '` is not of valid types for `slug` parameter.');
		}

		$this->slug = $slug;
		$this->name = $name;
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

}
