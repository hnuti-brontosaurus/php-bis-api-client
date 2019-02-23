<?php

namespace HnutiBrontosaurus\BisApiClient\Request;

use HnutiBrontosaurus\BisApiClient\InvalidArgumentException;


final class EventParameters extends Parameters
{

	const PARAM_DISPLAY_ALREADY_STARTED_KEY = 'aktualni';
	const PARAM_DISPLAY_ALREADY_STARTED_NO = 'od';
	const PARAM_DISPLAY_ALREADY_STARTED_YES = 'do';

	const PARAM_ORDER_BY_KEY = 'razeni';
	const PARAM_ORDER_BY_START_DATE = 'od';
	const PARAM_ORDER_BY_END_DATE = 'do';


	public function __construct()
	{
		parent::__construct([
			self::PARAM_QUERY => 'akce',
			self::PARAM_DISPLAY_ALREADY_STARTED_KEY => self::PARAM_DISPLAY_ALREADY_STARTED_YES,
			self::PARAM_ORDER_BY_KEY => self::PARAM_ORDER_BY_END_DATE,
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


	// filter

	const FILTER_CLUB = 1;
	const FILTER_WEEKEND = 2;
	const FILTER_CAMP = 4;
	const FILTER_EKOSTAN = 8;

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


	// type

	const TYPE_WORK = 'pracovni';
	const TYPE_EXPERIENCE = 'prozitkova';
	const TYPE_SPORT = 'sportovni';
	const TYPE_EDUCATIONAL = 'vzdelavaci';
	const TYPE_COURSE = 'prednaska';
	const TYPE_PUBLIC = 'verejnost';
	const TYPE_CLUB = 'klub';
	const TYPE_OHB = 'ohb';
	const TYPE_MEETING = 'schuzka';

	/**
	 * @param string $type
	 * @return self
	 */
	public function setType($type)
	{
		if ( ! \in_array($type, [
			self::TYPE_WORK,
			self::TYPE_EXPERIENCE,
			self::TYPE_SPORT,
			self::TYPE_EDUCATIONAL,
			self::TYPE_COURSE,
			self::TYPE_PUBLIC,
			self::TYPE_CLUB,
			self::TYPE_OHB,
			self::TYPE_MEETING,
		], true)) {
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


	// program

	const PROGRAM_NATURE = 'ap';
	const PROGRAM_SIGHTS = 'pamatky';
	const PROGRAM_BRDO = 'brdo';
	const PROGRAM_EKOSTAN = 'ekostan';
	const PROGRAM_PSB = 'psb';
	const PROGRAM_EDUCATION = 'vzdelavani';

	/**
	 * @param string $program
	 * @return self
	 */
	public function setProgram($program)
	{
		if ( ! \in_array($program, [
			self::PROGRAM_NATURE,
			self::PROGRAM_SIGHTS,
			self::PROGRAM_BRDO,
			self::PROGRAM_EKOSTAN,
			self::PROGRAM_PSB,
			self::PROGRAM_EDUCATION,
		], true)) {
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


	// target group

	const TARGET_GROUP_ADULTS = 'dospeli';
	const TARGET_GROUP_CHILDREN = 'deti';
	const TARGET_GROUP_FAMILIES = 'detirodice';
	const TARGET_GROUP_FIRST_TIME_ATTENDEES = 'prvouc';

	/**
	 * @param string $targetGroup
	 * @return self
	 */
	public function setTargetGroup($targetGroup)
	{
		if ( ! \in_array($targetGroup, [
			self::TARGET_GROUP_ADULTS,
			self::TARGET_GROUP_CHILDREN,
			self::TARGET_GROUP_FAMILIES,
			self::TARGET_GROUP_FIRST_TIME_ATTENDEES,
		], true)) {
			throw new InvalidArgumentException('Value `' . $targetGroup . '` is not of valid types for `for` parameter.');
		}

		$this->params['pro'] = $targetGroup;
		return $this;
	}


	// date constraints

	const PARAM_DATE_FORMAT = 'Y-m-d';

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
	public function hideTheseAlreadyStarted()
	{
		$this->params[self::PARAM_DISPLAY_ALREADY_STARTED_KEY] = self::PARAM_DISPLAY_ALREADY_STARTED_NO;
		return $this;
	}


	// miscellaneous

	/**
	 * @return self
	 */
	public function orderByStartDate()
	{
		$this->params[self::PARAM_ORDER_BY_KEY] = self::PARAM_ORDER_BY_START_DATE;
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
		if ( ! \is_array($unitIds)) {
			$unitIds = [$unitIds];
		}

		foreach ($unitIds as $unitId) {
			// If such value is not present yet, initialize it with an empty array.
			if ( ! \is_array($this->params[$organizedByKey])) {
				$this->params[$organizedByKey] = [];
			}

			$this->params[$organizedByKey][] = (int) $unitId;
		}

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
