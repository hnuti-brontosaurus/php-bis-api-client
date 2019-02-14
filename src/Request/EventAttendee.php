<?php

namespace HnutiBrontosaurus\BisApiClient\Request;


final class EventAttendee extends Parameters
{

	private $data = [];


	/**
	 * @param int $eventId
	 * @param string $firstName
	 * @param string $lastName
	 * @param string $birthDate
	 * @param string $phoneNumber
	 * @param string $emailAddress
	 * @param string|null $note
	 * @param string[]|null $questionAnswers
	 */
	public function __construct(
		$eventId,
		$firstName,
		$lastName,
		$birthDate,
		$phoneNumber,
		$emailAddress,
		$note,
		array $questionAnswers = null
	) {
		parent::__construct([
			self::PARAM_QUERY => 'prihlaska',
		]);


		// the rest goes to data array which will be sent in headers, not through URI

		$this->data = [
			'akce' => $eventId,
			'jmeno' => $firstName,
			'prijmeni' => $lastName,
			'telefon' => $phoneNumber,
			'email' => $emailAddress,
			'datum_narozeni' => $birthDate,
			'poznamka' => $note,
		];


		if (\count($questionAnswers) === 0) {
			return;
		}

		// currently 3 questions are supported
		$i = 1;
		foreach ($questionAnswers as $questionAnswer) {
			$this->data['add_info' . ($i >= 2 ? '_' . $i : '')] = $questionAnswer; // key syntax is `add_info` for first key and `add_info_X` for any other
			$i++;
		}
	}


	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}

}
