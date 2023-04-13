<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Request;

use Brick\DateTime\Clock;
use Brick\DateTime\LocalDate;
use Brick\DateTime\TimeZone;
use HnutiBrontosaurus\BisClient\Event\Category;
use HnutiBrontosaurus\BisClient\Event\Group;
use HnutiBrontosaurus\BisClient\Event\IntendedFor;
use HnutiBrontosaurus\BisClient\Event\Program;
use HnutiBrontosaurus\BisClient\LimitParameter;
use HnutiBrontosaurus\BisClient\QueryParameters;
use function count;
use function implode;


final class EventParameters implements QueryParameters
{
	use LimitParameter;

	private Ordering $ordering;
	private TimeZone $timeZone;

	public function __construct()
	{
		$this->timeZone = TimeZone::parse('Europe/Prague'); // Hnutí Brontosaurus operates in Czechia

		$this->setPeriod(Period::RUNNING_AND_FUTURE()); // no past because there are so many events in history
		$this->orderByEndDate();
	}



	// administration unit

	/** @var int[] */
	private array $administrationUnits = [];

	public function setAdministrationUnit(int $id): self
	{
		$this->administrationUnits = [$id];
		return $this;
	}

	/**
	 * @param int[] $ids
	 */
	public function setAdministrationUnits(array $ids): self
	{
		$this->administrationUnits = $ids;
		return $this;
	}


	// groups

	/** @var Group[] */
	private array $groups = [];

	public function setGroup(Group $group): self
	{
		$this->groups = [$group];
		return $this;
	}

	/**
	 * @param Group[] $groups
	 */
	public function setGroups(array $groups): self
	{
		$this->groups = $groups;
		return $this;
	}


	// category

	/** @var Category[] */
	private array $categories = [];

	public function setCategory(Category $category): self
	{
		$this->categories = [$category];
		return $this;
	}

	/**
	 * @param Category[] $categories
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

	private ?LocalDate $dateStartGreaterThanOrEqualTo = null;
	private ?LocalDate $dateStartLessThanOrEqualTo = null;
	private ?LocalDate $dateEndGreaterThanOrEqualTo = null;
	private ?LocalDate $dateEndLessThanOrEqualTo = null;

	public function setPeriod(Period $period, ?Clock $clock = null): self
	{
		// reset all
		$this->resetDates();

		$now = LocalDate::now($this->timeZone, $clock);

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

	public function setDateStartLessThanOrEqualTo(?LocalDate $date, bool $reset = false): self
	{
		if ($reset) $this->resetDates();
		$this->dateStartLessThanOrEqualTo = $date;
		return $this;
	}

	public function setDateStartGreaterThanOrEqualTo(?LocalDate $date, bool $reset = false): self
	{
		if ($reset) $this->resetDates();
		$this->dateStartGreaterThanOrEqualTo = $date;
		return $this;
	}

	public function setDateEndLessThanOrEqualTo(?LocalDate $date, bool $reset = false): self
	{
		if ($reset) $this->resetDates();
		$this->dateEndLessThanOrEqualTo = $date;
		return $this;
	}

	public function setDateEndGreaterThanOrEqualTo(?LocalDate $date, bool $reset = false): self
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

	public function orderByStartDate(bool $desc = false): self
	{
		$this->ordering = $desc ? Ordering::START_DATE_DESC() : Ordering::START_DATE_ASC();
		return $this;
	}

	public function orderByEndDate(bool $desc = false): self
	{
		$this->ordering = $desc ? Ordering::END_DATE_DESC() : Ordering::END_DATE_ASC();
		return $this;
	}


	// getters

	public function toArray(): array
	{
		$array = [
			'ordering' => $this->ordering->toScalar(),
		];

		if (count($this->administrationUnits) > 0) {
			$array['administration_unit'] = implode(',', $this->administrationUnits);
		}
		if (count($this->groups) > 0) {
			$array['group'] = implode(',', $this->groups);
		}
		if (count($this->categories) > 0) {
			$array['category'] = implode(',', $this->categories);
		}
		if (count($this->programs) > 0) {
			$array['program'] = implode(',', $this->programs);
		}
		if (count($this->intendedFor) > 0) {
			$array['intended_for'] = implode(',', $this->intendedFor);
		}

		if ($this->dateStartLessThanOrEqualTo !== null) {
			$array['start__lte'] = (string) $this->dateStartLessThanOrEqualTo; // conversion to string has to be there because of bug in php: https://github.com/php/php-src/issues/10229
		}
		if ($this->dateStartGreaterThanOrEqualTo !== null) {
			$array['start__gte'] = (string) $this->dateStartGreaterThanOrEqualTo; // conversion to string has to be there because of bug in php: https://github.com/php/php-src/issues/10229
		}
		if ($this->dateEndLessThanOrEqualTo !== null) {
			$array['end__lte'] = (string) $this->dateEndLessThanOrEqualTo; // conversion to string has to be there because of bug in php: https://github.com/php/php-src/issues/10229
		}
		if ($this->dateEndGreaterThanOrEqualTo !== null) {
			$array['end__gte'] = (string) $this->dateEndGreaterThanOrEqualTo; // conversion to string has to be there because of bug in php: https://github.com/php/php-src/issues/10229
		}

		return $array;
	}

}
