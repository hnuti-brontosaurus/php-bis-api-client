<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Request;

use DateTimeImmutable;
use DateTimeInterface;
use HnutiBrontosaurus\BisClient\Event\Category;
use HnutiBrontosaurus\BisClient\Event\Group;
use HnutiBrontosaurus\BisClient\Event\IntendedFor;
use HnutiBrontosaurus\BisClient\Event\Program;
use HnutiBrontosaurus\BisClient\Event\Tag;
use HnutiBrontosaurus\BisClient\LimitParameter;
use HnutiBrontosaurus\BisClient\QueryParameters;
use function count;
use function implode;


final class EventParameters implements QueryParameters
{
	use LimitParameter;

	private Ordering $ordering;

	public function __construct()
	{
		$this->setPeriod(Period::RUNNING_AND_FUTURE); // no past because there are so many events in history
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


	// region

	/** @var Region[] */
	private array $regions = [];

	public function setRegion(Region $region): self
	{
		$this->regions = [$region];
		return $this;
	}

	/**
	 * @param Region[] $regions
	 */
	public function setRegions(array $regions): self
	{
		$this->regions = $regions;
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


	// tag

	/** @var Tag[] */
	private array $tags = [];

	public function setTag(Tag $tag): self
	{
		$this->tags = [$tag];
		return $this;
	}

	/**
	 * @param Tag[] $tags
	 */
	public function setTags(array $tags): self
	{
		$this->tags = $tags;
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

	private ?DateTimeInterface $dateStartGreaterThanOrEqualTo = null;
	private ?DateTimeInterface $dateStartLessThanOrEqualTo = null;
	private ?DateTimeInterface $dateEndGreaterThanOrEqualTo = null;
	private ?DateTimeInterface $dateEndLessThanOrEqualTo = null;

	public function setPeriod(Period $period): self
	{
		// reset all
		$this->resetDates();

		$now = new DateTimeImmutable();

		if ($period === Period::RUNNING_ONLY) {
			$this->dateStartLessThanOrEqualTo = $now;
			$this->dateEndGreaterThanOrEqualTo = $now;

		} elseif ($period === Period::FUTURE_ONLY) {
			$this->dateStartGreaterThanOrEqualTo = $now;

		} elseif ($period === Period::PAST_ONLY) {
			$this->dateEndLessThanOrEqualTo = $now;

		} elseif ($period === Period::RUNNING_AND_FUTURE) {
			$this->dateEndGreaterThanOrEqualTo = $now;

		} elseif ($period === Period::RUNNING_AND_PAST) {
			$this->dateStartLessThanOrEqualTo = $now;

		} else {} // Period::UNLIMITED – default

		return $this;
	}

	public function setDateStartLessThanOrEqualTo(?DateTimeInterface $date, bool $reset = false): self
	{
		if ($reset) $this->resetDates();
		$this->dateStartLessThanOrEqualTo = $date;
		return $this;
	}

	public function setDateStartGreaterThanOrEqualTo(?DateTimeInterface $date, bool $reset = false): self
	{
		if ($reset) $this->resetDates();
		$this->dateStartGreaterThanOrEqualTo = $date;
		return $this;
	}

	public function setDateEndLessThanOrEqualTo(?DateTimeInterface $date, bool $reset = false): self
	{
		if ($reset) $this->resetDates();
		$this->dateEndLessThanOrEqualTo = $date;
		return $this;
	}

	public function setDateEndGreaterThanOrEqualTo(?DateTimeInterface $date, bool $reset = false): self
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
		$this->ordering = $desc ? Ordering::START_DATE_DESC : Ordering::START_DATE_ASC;
		return $this;
	}

	public function orderByEndDate(bool $desc = false): self
	{
		$this->ordering = $desc ? Ordering::END_DATE_DESC : Ordering::END_DATE_ASC;
		return $this;
	}


	// getters

	public function toArray(): array
	{
		$array = [
			'ordering' => $this->ordering->value,
		];

		if (count($this->administrationUnits) > 0) {
			$array['administration_unit'] = implode(',', $this->administrationUnits);
		}
		if (count($this->regions) > 0) {
			$array['region'] = self::joinEnumValues($this->regions);
		}
		if (count($this->groups) > 0) {
			$array['group'] = self::joinEnumValues($this->groups);
		}
		if (count($this->categories) > 0) {
			$array['category'] = self::joinEnumValues($this->categories);
		}
		if (count($this->tags) > 0) {
			$array['tags'] = self::joinEnumValues($this->tags);
		}
		if (count($this->programs) > 0) {
			$array['program'] = self::joinEnumValues($this->programs);
		}
		if (count($this->intendedFor) > 0) {
			$array['intended_for'] = self::joinEnumValues($this->intendedFor);
		}

		if ($this->dateStartLessThanOrEqualTo !== null) {
			$array['start__lte'] = (string) $this->dateStartLessThanOrEqualTo->format('Y-m-d'); // conversion to string has to be there because of bug in php: https://github.com/php/php-src/issues/10229
		}
		if ($this->dateStartGreaterThanOrEqualTo !== null) {
			$array['start__gte'] = (string) $this->dateStartGreaterThanOrEqualTo->format('Y-m-d'); // conversion to string has to be there because of bug in php: https://github.com/php/php-src/issues/10229
		}
		if ($this->dateEndLessThanOrEqualTo !== null) {
			$array['end__lte'] = (string) $this->dateEndLessThanOrEqualTo->format('Y-m-d'); // conversion to string has to be there because of bug in php: https://github.com/php/php-src/issues/10229
		}
		if ($this->dateEndGreaterThanOrEqualTo !== null) {
			$array['end__gte'] = (string) $this->dateEndGreaterThanOrEqualTo->format('Y-m-d'); // conversion to string has to be there because of bug in php: https://github.com/php/php-src/issues/10229
		}

		return $array;
	}

	private static function joinEnumValues(array $enums): string
	{
		return implode(',', array_map(static fn($enum) => $enum->value, $enums));
	}

}
