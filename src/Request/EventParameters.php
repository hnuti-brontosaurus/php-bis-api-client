<?php

namespace HnutiBrontosaurus\BisApiClient\Request;

use HnutiBrontosaurus\BisApiClient\InvalidArgumentException;


final class EventParameters extends Parameters
{

	const FILTER_CLUB = 1;
	const FILTER_WEEKEND = 2;
	const FILTER_CAMP = 4;
	const FILTER_EKOSTAN = 8;

	const TYPE_WORK = 'pracovni';
	const TYPE_EXPERIENCE = 'prozitkova';
	const TYPE_SPORT = 'sportovni';
	const TYPE_EDUCATIONAL = 'vzdelavaci';
	const TYPE_COURSE = 'prednaska';
	const TYPE_PUBLIC = 'verejnost';
	const TYPE_CLUB = 'klub';
	const TYPE_OHB = 'ohb';

	const PROGRAM_NATURE = 'ap';
	const PROGRAM_SIGHTS = 'pamatky';
	const PROGRAM_BRDO = 'brdo';
	const PROGRAM_EKOSTAN = 'ekostan';
	const PROGRAM_PSB = 'psb';
	const PROGRAM_EDUCATION = 'vzdelavani';

	const FOR_ADULTS = 'dospeli';
	const FOR_CHILDREN = 'deti';
	const FOR_FAMILIES = 'detirodice';

	const PARAM_DATE_FORMAT = 'Y-m-d';


	public function __construct()
	{
		parent::__construct([
			self::PARAM_QUERY => 'akce'
		]);
	}


	/**
	 * @param int $id
	 * @return self
	 */
	public function setId($id)
	{
		$this->params['id'] = (int) $id;
		return $this;
	}

	/**
	 * Beside standard constant usage as a paramer, you can pass bitwise operation argument, e.g. `EventParameters::FILTER_WEEKEND|EventParameters::FILTER_CAMP`.
	 * @param int $filter
	 * @return self
	 */
	public function setFilter($filter)
	{
		$keys = [
			self::FILTER_CLUB => 'klub',
			self::FILTER_WEEKEND => 'vik',
			self::FILTER_CAMP => 'tabor',
			self::FILTER_EKOSTAN => 'ekostan',
		];

		switch ($filter) {
			case self::FILTER_CLUB:
			case self::FILTER_WEEKEND:
			case self::FILTER_CAMP:
			case self::FILTER_EKOSTAN:
				$param = $keys[$filter];
				break;

			case self::FILTER_WEEKEND | self::FILTER_CAMP:
				$param = $keys[self::FILTER_WEEKEND] . $keys[self::FILTER_CAMP];
				break;

			case self::FILTER_WEEKEND | self::FILTER_EKOSTAN:
				$param = $keys[self::FILTER_WEEKEND] . $keys[self::FILTER_EKOSTAN];
				break;

			default:
				throw new InvalidArgumentException('Value `' . $filter . '` is not of valid types and their combinations for `filter` parameter. Only `weekend+camp` and `weekend+ekostan` can be combined.');
				break;
		}

		$this->params['filter'] = $param;

		return $this;
	}

	/**
	 * @param string $type
	 * @return self
	 */
	public function setType($type)
	{
		if (!\in_array($type, [
			self::TYPE_WORK,
			self::TYPE_EXPERIENCE,
			self::TYPE_SPORT,
			self::TYPE_EDUCATIONAL,
			self::TYPE_COURSE,
			self::TYPE_PUBLIC,
		], TRUE)) {
			throw new InvalidArgumentException('Value `' . $type . '` is not of valid types for `type` parameter.');
		}

		$this->params['typ'][] = $type;
		return $this;
	}

	/**
	 * @param string[] $types
	 * @return self
	 */
	public function setTypes(array $types)
	{
		foreach ($types as $type) {
			$this->setType($type);
		}

		return $this;
	}

	/**
	 * @param string $program
	 * @return self
	 */
	public function setProgram($program)
	{
		if (!\in_array($program, [
			self::PROGRAM_NATURE,
			self::PROGRAM_SIGHTS,
			self::PROGRAM_BRDO,
			self::PROGRAM_EKOSTAN,
			self::PROGRAM_PSB,
			self::PROGRAM_EDUCATION,
		], TRUE)) {
			throw new InvalidArgumentException('Value `' . $program . '` is not of valid types for `program` parameter.');
		}

		$this->params['program'][] = $program;
		return $this;
	}

	/**
	 * @param string[] $programs
	 * @return self
	 */
	public function setPrograms(array $programs)
	{
		foreach ($programs as $program) {
			$this->setProgram($program);
		}

		return $this;
	}

	/**
	 * @param string $for
	 * @return self
	 */
	public function setFor($for)
	{
		if (!\in_array($for, [
			self::FOR_ADULTS,
			self::FOR_CHILDREN,
			self::FOR_FAMILIES,
		], TRUE)) {
			throw new InvalidArgumentException('Value `' . $for . '` is not of valid types for `for` parameter.');
		}

		$this->params['pro'] = $for;
		return $this;
	}

	/**
	 * @param int|int[] $unitIds
	 * @return self
	 */
	public function setOrganizedBy($unitIds)
	{
		$organizedByKey = 'zc';

		// If just single value, wrap it into an array.
		if (!\is_array($unitIds)) {
			$unitIds = [$unitIds];
		}

		foreach ($unitIds as $unitId) {
			// If such value is not present yet, initialize it with an empty array.
			if (!\is_array($this->params[$organizedByKey])) {
				$this->params[$organizedByKey] = [];
			}

			$this->params[$organizedByKey][] = (int) $unitId;
		}

		return $this;
	}

	/**
	 * @param \DateTimeImmutable $dateFrom
	 * @return self
	 */
	public function setFrom(\DateTimeImmutable $dateFrom)
	{
		$this->params['od'] = $dateFrom->format(self::PARAM_DATE_FORMAT);
		return $this;
	}

	/**
	 * @param \DateTimeImmutable $dateFrom
	 * @return self
	 */
	public function setUntil(\DateTimeImmutable $dateFrom)
	{
		$this->params['do'] = $dateFrom->format(self::PARAM_DATE_FORMAT);
		return $this;
	}

	/**
	 * @param int $year
	 * @return self
	 */
	public function setYear($year)
	{
		$this->params['rok'] = (int) $year;
		return $this;
	}

	/**
	 * @return self
	 */
	public function includeNonPublic()
	{
		$this->params['vse'] = 1;
		return $this;
	}

}
