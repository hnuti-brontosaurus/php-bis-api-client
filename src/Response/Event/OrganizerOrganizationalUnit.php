<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisApiClient\Response\Event;


/**
 * This could be OrganizationalUnit instead as well, but one more request per each event would be generated which is kinda wasteful. And Brontosaurus does not want any more waste... :-)
 */
final class OrganizerOrganizationalUnit
{

	/** @var int */
	private $id;

	/** @var string */
	private $name;


	/**
	 * @param int $id
	 * @param string $name
	 */
	private function __construct($id, $name)
	{
		$this->id = $id;
		$this->name = $name;
	}

	/**
	 * @param int $id
	 * @param string $name
	 * @return self
	 */
	public static function from($id, $name)
	{
		return new self($id, $name);
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

}
