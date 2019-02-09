<?php

namespace HnutiBrontosaurus\BisApiClient\Response\Event;


final class Place
{

	/** @var int|null */
	private $id;

	/** @var string */
	private $name;

	/** @var string|null */
	private $mapLink;

	/** @var string|null */
	private $coords;


	/**
	 * @param int|null $id
	 * @param string $name
	 * @param string|null $mapLinkOrCoords Map hypertext link or coordinates depending on what user has filled in BIS.
	 */
	private function __construct($id = null, $name, $mapLinkOrCoords = null)
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
	 * @param int|null $id
	 * @param string $name
	 * @param string|null $mapLinkOrCoords
	 * @return self
	 */
	public static function from(
		$id = null,
		$name,
		$mapLinkOrCoords = null
	) {
		return new self($id, $name, $mapLinkOrCoords);
	}


	/**
	 * @return int|null
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
	 * @return string|null
	 */
	public function getMapLink()
	{
		return $this->mapLink;
	}

	/**
	 * @return string|null
	 */
	public function getCoords()
	{
		return $this->coords;
	}

}
