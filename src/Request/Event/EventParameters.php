<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Request\Event;

use HnutiBrontosaurus\BisClient\Enums\EventCategory;
use HnutiBrontosaurus\BisClient\Enums\EventGroup;
use HnutiBrontosaurus\BisClient\Enums\Program;
use HnutiBrontosaurus\BisClient\Enums\IntendedFor;
use HnutiBrontosaurus\BisClient\Request\LimitParameter;
use HnutiBrontosaurus\BisClient\Request\QueryParameters;


final class EventParameters implements QueryParameters
{
	use LimitParameter;

	private Ordering $ordering;

	public function __construct()
	{
		$this->setPeriod(Period::RUNNING_AND_FUTURE()); // no past because there are so many events in history
		$this->orderByDateEnd();
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


	// period

	private ?\DateTimeImmutable $dateStartGreaterThanOrEqualTo = null;
	private ?\DateTimeImmutable $dateStartLessThanOrEqualTo = null;
	private ?\DateTimeImmutable $dateEndGreaterThanOrEqualTo = null;
	private ?\DateTimeImmutable $dateEndLessThanOrEqualTo = null;

	public function setPeriod(Period $period): self
	{
		// reset all
		$this->resetDates();

		$now = new \DateTimeImmutable();

		if ($period->equals(Period::RUNNING_ONLY())) {
			$this->dateStartLessThanOrEqualTo = $now;
			$this->dateEndGreaterThanOrEqualTo = $now;

		} elseif ($period->equals(Period::FUTURE_ONLY())) {
			$this->dateStartGreaterThanOrEqualTo = $now;

		} elseif ($period->equals(Period::PAST_ONLY())) {
			$this->dateEndLessThanOrEqualTo = $now;

		} elseif ($period->equals(Period::RUNNING_AND_FUTURE())) {
			$this->dateEndGreaterThanOrEqualTo = $now;

		} elseif ($period->equals(Period::RUNNING_AND_PAST())) {
			$this->dateStartLessThanOrEqualTo = $now;

		} else {} // Period::UNLIMITED() – default

		return $this;
	}

	public function setDateStartLessThanOrEqualTo(?\DateTimeImmutable $date, bool $reset = false): self
	{
		if ($reset) $this->resetDates();
		$this->dateStartLessThanOrEqualTo = $date;
		return $this;
	}

	public function setDateStartGreaterThanOrEqualTo(?\DateTimeImmutable $date, bool $reset = false): self
	{
		if ($reset) $this->resetDates();
		$this->dateStartGreaterThanOrEqualTo = $date;
		return $this;
	}

	public function setDateEndLessThanOrEqualTo(?\DateTimeImmutable $date, bool $reset = false): self
	{
		if ($reset) $this->resetDates();
		$this->dateEndLessThanOrEqualTo = $date;
		return $this;
	}

	public function setDateEndGreaterThanOrEqualTo(?\DateTimeImmutable $date, bool $reset = false): self
	{
		if ($reset) $this->resetDates();
		$this->dateEndGreaterThanOrEqualTo = $date;
		return $this;
	}

	public function resetDates(): self
	{
		$this->dateStartLessThanOrEqualTo = null;
		$this->dateStartGreaterThanOrEqualTo = null;
		$this->dateEndLessThanOrEqualTo = null;
		$this->dateEndGreaterThanOrEqualTo = null;
		return $this;
	}


	// ordering

	public function orderByDateStart(bool $desc = false): self
	{
		$this->ordering = $desc ? Ordering::DATE_START_DESC() : Ordering::DATE_START_ASC();
		return $this;
	}

	public function orderByDateEnd(bool $desc = false): self
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

		if ($this->dateStartLessThanOrEqualTo !== null) {
			$array['start__lte'] = $this->dateStartLessThanOrEqualTo->format('Y-m-d');
		}
		if ($this->dateStartGreaterThanOrEqualTo !== null) {
			$array['start__gte'] = $this->dateStartGreaterThanOrEqualTo->format('Y-m-d');
		}
		if ($this->dateEndLessThanOrEqualTo !== null) {
			$array['end__lte'] = $this->dateEndLessThanOrEqualTo->format('Y-m-d');
		}
		if ($this->dateEndGreaterThanOrEqualTo !== null) {
			$array['end__gte'] = $this->dateEndGreaterThanOrEqualTo->format('Y-m-d');
		}

		return $array;
	}

}
