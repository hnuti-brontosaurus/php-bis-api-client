<?php

namespace HnutiBrontosaurus\BisApiClient\Response;


final class Organizer
{

	/** @var OrganizerOrganizationalUnit|NULL */
	private $organizationalUnit;

	/** @var string|NULL */
	private $responsiblePerson;

	/** @var string|NULL */
	private $organizers;

	/** @var string|NULL */
	private $contactPersonName;

	/** @var string */
	private $contactPhone;

	/** @var string */
	private $contactEmail;

	/** @var string|NULL */
	private $contactWebsite;


	/**
	 * @param OrganizerOrganizationalUnit|NULL $organizationalUnit
	 * @param string|NULL $responsiblePerson
	 * @param string|NULL $organizers
	 * @param string|NULL $contactPersonName
	 * @param string $contactPhone
	 * @param string $contactEmail
	 * @param string|NULL $contactWebsite
	 */
	public function __construct(
		OrganizerOrganizationalUnit $organizationalUnit = NULL,
		$responsiblePerson = NULL,
		$organizers = NULL,
		$contactPersonName = NULL,
		$contactPhone,
		$contactEmail,
		$contactWebsite = NULL
	)
	{
		$this->organizationalUnit = $organizationalUnit;
		$this->responsiblePerson = $responsiblePerson;
		$this->organizers = $organizers;
		$this->contactPersonName = $contactPersonName;
		$this->contactPhone = $contactPhone;
		$this->contactEmail = $contactEmail;
		$this->contactWebsite = $contactWebsite;
	}


	/**
	 * @return OrganizerOrganizationalUnit|NULL
	 */
	public function getOrganizationalUnit()
	{
		return $this->organizationalUnit;
	}

	/**
	 * @return string|NULL
	 */
	public function getResponsiblePerson()
	{
		return $this->responsiblePerson;
	}

	/**
	 * @return string|NULL
	 */
	public function getOrganizers()
	{
		return $this->organizers;
	}

	/**
	 * @return string|NULL
	 */
	public function getContactPersonName()
	{
		return $this->contactPersonName;
	}

	/**
	 * @return string
	 */
	public function getContactPhone()
	{
		return $this->contactPhone;
	}

	/**
	 * @return string
	 */
	public function getContactEmail()
	{
		return $this->contactEmail;
	}

	/**
	 * @return string|NULL
	 */
	public function getContactWebsite()
	{
		return $this->contactWebsite;
	}

}
