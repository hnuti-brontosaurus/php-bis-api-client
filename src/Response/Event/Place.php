<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisApiClient\Response\Event;


final class Place
{

	/** @var string */
	private $name;

	/**
	 * In format `49.132456 16.123456`.
	 * @var string|null
	 */
	private $coordinates;


	/**
	 * @param string $name
	 * @param string|null $alternativeName
	 * @param string|null $coordinates
	 */
	private function __construct(
		$name,
		$alternativeName = null,
		$coordinates = null
	) {
		$this->name = $alternativeName !== null ? $alternativeName : $name; // It looks like alternative names are more concrete.

		if ($coordinates !== null && \preg_match('|[0-9]+(\.[0-9]+) [0-9]+(\.[0-9]+)|', $coordinates)) { // Only `49.132456 16.123456` format is used by users right now.
			$this->coordinates = $coordinates;
		}
	}

	/**
	 * @param string $name
	 * @param string|null $alternativeName
	 * @param string|null $coordinates
	 * @return self
	 */
	public static function from(
		$name,
		$alternativeName = null,
		$coordinates = null
	) {
		return new self($name, $alternativeName, $coordinates);
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
	public function areCoordinatesListed()
	{
		return $this->coordinates !== null;
	}

	/**
	 * @return string|null
	 */
	public function getCoordinates()
	{
		return $this->coordinates;
	}

}
