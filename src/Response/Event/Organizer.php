<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisApiClient\Response\Event;


final class Organizer
{

	private ?OrganizerOrganizationalUnit $organizationalUnit;
	private ?string $responsiblePerson;
	private ?string $organizers;
	private ?string $contactPersonName;
	private string $contactPhone;
	private string $contactEmail;


	private function __construct(
		?int $organizationalUnitId,
		?string $organizationalUnitName,
		?string $responsiblePerson,
		?string $organizers,
		?string $contactPersonName,
		string $contactPhone,
		string $contactEmail,
	) {
		$this->organizationalUnit = ($organizationalUnitId !== null && $organizationalUnitName !== null) ? OrganizerOrganizationalUnit::from($organizationalUnitId, $organizationalUnitName) : null;
		$this->responsiblePerson = $responsiblePerson;
		$this->organizers = $organizers;
		$this->contactPersonName = $contactPersonName;
		$this->contactPhone = $contactPhone;
		$this->contactEmail = $contactEmail;
	}

	/**
	 * @param int|null $organizationalUnitId
	 * @param string|null $organizationalUnitName
	 * @param string|null $responsiblePerson
	 * @param string|null $organizers
	 * @param string|null $contactPersonName
	 * @param string $contactPhone
	 * @param string $contactEmail
	 *
	 * @return self
	 */
	public static function from(
		?int $organizationalUnitId,
		?string $organizationalUnitName,
		?string $responsiblePerson,
		?string $organizers,
		?string $contactPersonName,
		string $contactPhone,
		string $contactEmail
	): self
	{
		return new self(
			$organizationalUnitId,
			$organizationalUnitName,
			$responsiblePerson,
			$organizers,
			$contactPersonName,
			$contactPhone,
			$contactEmail
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

}
