<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Request\Event;

use HnutiBrontosaurus\BisClient\Enums\EventCategory;
use HnutiBrontosaurus\BisClient\Enums\EventGroup;
use HnutiBrontosaurus\BisClient\Enums\Program;
use HnutiBrontosaurus\BisClient\Enums\IntendedFor;
use HnutiBrontosaurus\BisClient\Request\ToArray;


final class EventParameters implements ToArray
{

	private Ordering $ordering;

	public function __construct()
	{
		$this->setPeriod(Period::UNLIMITED());
		$this->orderByDateTo();
	}



	// groups

	/** @var EventGroup[] */
	private array $groups = [];

	public function setGroup(EventGroup $group): self
	{
		$this->groups = [$group];
		return $this;
	}

	/**
	 * @param EventGroup[] $groups
	 */
	public function setGroups(array $groups): self
	{
		$this->groups = $groups;
		return $this;
	}


	// category

	/** @var EventCategory[] */
	private array $categories = [];

	public function setCategory(EventCategory $category): self
	{
		$this->categories = [$category];
		return $this;
	}

	/**
	 * @param EventCategory[] $categories
	 */
	public function setCategories(array $categories): self
	{
		$this->categories = $categories;
		return $this;
	}


	// program

	/** @var Program[] */
	private array $programs = [];

	public function setProgram(Program $program): self
	{
		$this->programs = [$program];
		return $this;
	}

	/**
	 * @param Program[] $programs
	 */
	public function setPrograms(array $programs): self
	{
		$this->programs = $programs;
		return $this;
	}


	// intended for

	/** @var IntendedFor[] */
	private array $intendedFor = [];

	public function setIntendedFor(IntendedFor $intendedFor): self
	{
		$this->intendedFor = [$intendedFor];
		return $this;
	}

	/**
	 * @param IntendedFor[] $intendedFor
	 */
	public function setMultipleIntendedFor(array $intendedFor): self
	{
		$this->intendedFor = $intendedFor;
		return $this;
	}


	// period (defaults to unlimited)

	private \DateTimeImmutable $dateStartGreaterThanOrEqualTo;
	private \DateTimeImmutable $dateStartLessThanOrEqualTo;
	private \DateTimeImmutable $dateEndGreaterThanOrEqualTo;
	private \DateTimeImmutable $dateEndLessThanOrEqualTo;

	public function setPeriod(Period $period): self
	{
		$now = new \DateTimeImmutable();

		/**
		 * Older events have some missing data so typing ono php level could not be enforced.
		 * As listing of such old events is not expected, setting this minimum date should be safe.
		 */
		$min = \DateTimeImmutable::createFromFormat('Y-m-d', '2015-01-01');
		\assert($min !== false);

		if ($period->equals(Period::RUNNING_ONLY())) {
			$this->dateStartLessThanOrEqualTo = $now;
			$this->dateEndGreaterThanOrEqualTo = $now;

		} elseif ($period->equals(Period::FUTURE_ONLY())) {
			$this->dateStartGreaterThanOrEqualTo = $now;

		} elseif ($period->equals(Period::PAST_ONLY())) {
			$this->dateStartGreaterThanOrEqualTo = $min;
			$this->dateEndLessThanOrEqualTo = $now;

		} elseif ($period->equals(Period::RUNNING_AND_FUTURE())) {
			$this->dateEndGreaterThanOrEqualTo = $now;

		} elseif ($period->equals(Period::RUNNING_AND_PAST())) {
			$this->dateStartGreaterThanOrEqualTo = $min;
			$this->dateStartLessThanOrEqualTo = $now;

		} else { // Period::UNLIMITED() – default
			$this->dateStartGreaterThanOrEqualTo = $min;
		}

		return $this;
	}


	// ordering

	public function orderByDateFrom(bool $desc = false): self
	{
		$this->ordering = $desc ? Ordering::DATE_START_DESC() : Ordering::DATE_START_ASC();
		return $this;
	}

	public function orderByDateTo(bool $desc = false): self
	{
		$this->ordering = $desc ? Ordering::DATE_END_DESC() : Ordering::DATE_END_ASC();
		return $this;
	}


	// getters

	public function toArray(): array
	{
		$array = [
			'ordering' => $this->ordering,
		];

		if (\count($this->groups) > 0) {
			$array['group'] = \implode(',', $this->groups);
		}
		if (\count($this->categories) > 0) {
			$array['category'] = \implode(',', $this->categories);
		}
		if (\count($this->programs) > 0) {
			$array['program'] = \implode(',', $this->programs);
		}
		if (\count($this->intendedFor) > 0) {
			$array['intended_for'] = \implode(',', $this->intendedFor);
		}

		if (isset($this->dateStartLessThanOrEqualTo)) {
			$array['start__lte'] = $this->dateStartLessThanOrEqualTo->format('Y-m-d');
		}
		if (isset($this->dateStartGreaterThanOrEqualTo)) {
			$array['start__gte'] = $this->dateStartGreaterThanOrEqualTo->format('Y-m-d');
		}
		if (isset($this->dateEndLessThanOrEqualTo)) {
			$array['end__lte'] = $this->dateEndLessThanOrEqualTo->format('Y-m-d');
		}
		if (isset($this->dateEndGreaterThanOrEqualTo)) {
			$array['end__gte'] = $this->dateEndGreaterThanOrEqualTo->format('Y-m-d');
		}

		return $array;
	}

}
