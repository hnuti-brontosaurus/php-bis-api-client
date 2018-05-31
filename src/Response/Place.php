<?php

namespace HnutiBrontosaurus\BisApiClient\Response;


final class Place
{

	/** @var int|NULL */
	private $id;

	/** @var string */
	private $name;

	/** @var string|NULL */
	private $mapLink;

	/** @var string|NULL */
	private $coords;


	/**
	 * @param int|NULL $id
	 * @param string $name
	 * @param string|NULL $mapLinkOrCoords Map hypertext link or coordinates depending on what user has filled in BIS.
	 */
	public function __construct($id = NULL, $name, $mapLinkOrCoords = NULL)
	{
		$this->id = $id;
		$this->name = $name;

		if (\strncmp($mapLinkOrCoords, 'http', \strlen('http')) === 0) { // Copied from `Nette\Utils\Strings::startsWith()`.
			$this->mapLink = $mapLinkOrCoords;
		}
		elseif (\preg_match('|[0-9]+(\.[0-9]+)N, [0-9]+(\.[0-9]+)E|', $mapLinkOrCoords)) { // Only `49.132456N, 16.123456E` format is used by users right now.
			$this->coords = $mapLinkOrCoords;
		}
	}


	/**
	 * @return int|NULL
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
	 * @return string|NULL
	 */
	public function getMapLink()
	{
		return $this->mapLink;
	}

	/**
	 * @return string|NULL
	 */
	public function getCoords()
	{
		return $this->coords;
	}

}
