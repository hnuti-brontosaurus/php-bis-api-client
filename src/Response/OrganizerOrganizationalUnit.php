<?php

namespace HnutiBrontosaurus\BisApiClient\Response;


/**
 * This could be OrganizationalUnit instead as well, but one more request per each event would be generated which is kinda wasteful. And Brontosaurus does not want any more waste...
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
	public function __construct($id, $name)
	{
		$this->id = $id;
		$this->name = $name;
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
