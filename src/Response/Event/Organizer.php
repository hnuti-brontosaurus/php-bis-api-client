<?php

namespace HnutiBrontosaurus\BisApiClient\Response\Event;


final class Organizer
{

	/** @var OrganizerOrganizationalUnit|null */
	private $organizationalUnit;

	/** @var string|null */
	private $responsiblePerson;

	/** @var string|null */
	private $organizers;

	/** @var string|null */
	private $contactPersonName;

	/** @var string */
	private $contactPhone;

	/** @var string */
	private $contactEmail;

	/** @var string|null */
	private $contactWebsite;


	/**
	 * @param int|null $organizationalUnitId
	 * @param string|null $organizationalUnitName
	 * @param string|null $responsiblePerson
	 * @param string|null $organizers
	 * @param string|null $contactPersonName
	 * @param string $contactPhone
	 * @param string $contactEmail
	 * @param string|null $contactWebsite
	 */
	private function __construct(
		$organizationalUnitId = null,
		$organizationalUnitName = null,
		$responsiblePerson = null,
		$organizers = null,
		$contactPersonName = null,
		$contactPhone,
		$contactEmail,
		$contactWebsite = null
	) {
		$this->organizationalUnit = ($organizationalUnitId !== null && $organizationalUnitName !== null) ? OrganizerOrganizationalUnit::from($organizationalUnitId, $organizationalUnitName) : null;
		$this->responsiblePerson = $responsiblePerson;
		$this->organizers = $organizers;
		$this->contactPersonName = $contactPersonName;
		$this->contactPhone = $contactPhone;
		$this->contactEmail = $contactEmail;
		$this->contactWebsite = $contactWebsite;
	}

	/**
	 * @param int|null $organizationalUnitId
	 * @param string|null $organizationalUnitName
	 * @param string|null $responsiblePerson
	 * @param string|null $organizers
	 * @param string|null $contactPersonName
	 * @param string $contactPhone
	 * @param string $contactEmail
	 * @param string|null $contactWebsite
	 *
	 * @return self
	 */
	public static function from(
		$organizationalUnitId = null,
		$organizationalUnitName = null,
		$responsiblePerson = null,
		$organizers = null,
		$contactPersonName = null,
		$contactPhone,
		$contactEmail,
		$contactWebsite = null
	) {
		return new self(
			$organizationalUnitId,
			$organizationalUnitName,
			$responsiblePerson,
			$organizers,
			$contactPersonName,
			$contactPhone,
			$contactEmail,
			$contactWebsite
		);
	}


	/**
	 * @return OrganizerOrganizationalUnit|null
	 */
	public function getOrganizationalUnit()
	{
		return $this->organizationalUnit;
	}

	/**
	 * @return string|null
	 */
	public function getResponsiblePerson()
	{
		return $this->responsiblePerson;
	}

	/**
	 * @return bool
	 */
	public function areOrganizersListed()
	{
		return $this->organizers !== null;
	}

	/**
	 * @return string|null
	 */
	public function getOrganizers()
	{
		return $this->organizers;
	}

	/**
	 * @return string|null
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
	 * @return string|null
	 */
	public function getContactWebsite()
	{
		return $this->contactWebsite;
	}

}
