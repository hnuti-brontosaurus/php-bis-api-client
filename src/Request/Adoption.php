<?php

namespace HnutiBrontosaurus\BisApiClient\Request;


final class Adoption extends Parameters
{

	private $data = [];


	/**
	 * @param int $amount
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $streetAddress
	 * @param string $streetNumber
	 * @param string $postalCode
	 * @param string $city
	 * @param string $emailAddress
	 * @param int|null $preferredUnitOfTypeRegional
	 * @param int|null $preferredUnitOfTypeBase
	 * @param bool $excludeFromPublic
	 */
	public function __construct(
		$amount,
		$firstName,
		$lastName,
		$streetAddress,
		$streetNumber,
		$postalCode,
		$city,
		$emailAddress,
		$preferredUnitOfTypeRegional = null,
		$preferredUnitOfTypeBase = null,
		$excludeFromPublic
	) {
		parent::__construct([
			self::PARAM_QUERY => 'adopce',
		]);


		// the rest goes to data array which will be sent in headers, not through URI

		$this->data = [
			'f_jmeno' => $firstName,
			'f_prijmeni' => $lastName,
			'f_ulice' => $streetAddress . ' ' . $streetNumber,
			'f_mesto' => $city,
			'f_psc' => $postalCode,
			'f_email' => $emailAddress,
			'f_pohlavi' => null, // not required, but accepted by BIS (values muz/zena)
			'f_uvest_v_seznamu' => $excludeFromPublic ? 'off' : 'on',
			'f_clanek' => $preferredUnitOfTypeBase,
			'f_rc' => $preferredUnitOfTypeRegional,
			'f_castka' => $amount,
		];
	}


	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}

}
