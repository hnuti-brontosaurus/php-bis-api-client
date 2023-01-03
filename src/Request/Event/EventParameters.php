<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Request\Event;

use HnutiBrontosaurus\BisClient\Enums\EventType;
use HnutiBrontosaurus\BisClient\Enums\Program;
use HnutiBrontosaurus\BisClient\Enums\TargetGroup;
use HnutiBrontosaurus\BisClient\Request\ToArray;
use HnutiBrontosaurus\BisClient\UsageException;


final class EventParameters implements ToArray
{

	private Ordering $ordering;

	public function __construct()
	{
		$this->orderByDateTo();
	}



	// filter

	public const FILTER_ACTIONS_ONLY = 'action';
	public const FILTER_CAMPS_ONLY = 'camp';

	private string $filter = '';

	public function setFilter($filter): self
	{
		if ( ! \in_array($filter, [
			self::FILTER_ACTIONS_ONLY,
			self::FILTER_CAMPS_ONLY,
		])) {
			throw new UsageException('Value `' . $filter . '` is not of valid filters');
		}

		$this->filter = $filter;
		return $this;
	}


	// type

	/** @var EventType[] */
	private array $types = [];

	public function setType(EventType $type): self
	{
		$this->types = [$type];
		return $this;
	}

	/**
	 * @param EventType[] $types
	 */
	public function setTypes(array $types): self
	{
		$this->types = $types;
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


	// target group

	/** @var TargetGroup[] */
	private array $targetGroups = [];

	public function setTargetGroup(TargetGroup $targetGroup): self
	{
		$this->targetGroups = [$targetGroup];
		return $this;
	}

	/**
	 * @param TargetGroup[] $targetGroups
	 */
	public function setTargetGroups(array $targetGroups): self
	{
		$this->targetGroups = $targetGroups;
		return $this;
	}


	// period (defaults to unlimited)

	private \DateTimeImmutable $dateFromGreaterThanOrEqualTo;
	private \DateTimeImmutable $dateFromLessThanOrEqualTo;
	private \DateTimeImmutable $dateToGreaterThanOrEqualTo;
	private \DateTimeImmutable $dateToLessThanOrEqualTo;

	public function setPeriod(Period $period): self
	{
		if ($period->equals(Period::RUNNING_ONLY())) {
			$this->dateFromLessThanOrEqualTo = new \DateTimeImmutable();
			$this->dateToGreaterThanOrEqualTo = new \DateTimeImmutable();

		} elseif ($period->equals(Period::FUTURE_ONLY())) {
			$this->dateFromGreaterThanOrEqualTo = new \DateTimeImmutable();

		} elseif ($period->equals(Period::PAST_ONLY())) {
			$this->dateToLessThanOrEqualTo = new \DateTimeImmutable();

		} elseif ($period->equals(Period::RUNNING_AND_FUTURE())) {
			$this->dateToGreaterThanOrEqualTo = new \DateTimeImmutable();

		} elseif ($period->equals(Period::RUNNING_AND_PAST())) {
			$this->dateFromLessThanOrEqualTo = new \DateTimeImmutable();

		} else {} // Period::UNLIMITED() – default

		return $this;
	}



	// miscellaneous

	public function orderByDateFrom(): self
	{
		$this->ordering = Ordering::DATE_FROM();
		return $this;
	}

	public function orderByDateTo(): self
	{
		$this->ordering = Ordering::DATE_TO();
		return $this;
	}


	/** @var int[] */
	private array $organizedBy = [];

	/**
	 * @param int|int[] $unitIds
	 */
	public function setOrganizedBy(array|int $unitIds): self
	{
		// If just single value, wrap it into an array.
		if ( ! \is_array($unitIds)) {
			$this->organizedBy = [$unitIds];
			return $this;
		}

		$this->organizedBy = $unitIds;
		return $this;
	}



	// getters

	public function toArray(): array
	{
		$array = [
			'basic_purpose' => $this->filter,
			'event_type_array' => \implode(',', $this->types),
			'program_array' => \implode(',', $this->programs),
			'indended_for_array' => \implode(',', $this->targetGroups),
			'ordering' => $this->ordering,
			'administrative_unit' => \implode(',', $this->organizedBy),
		];

		if (isset($this->dateFromGreaterThanOrEqualTo)) {
			$array['date_from__gte'] = $this->dateFromGreaterThanOrEqualTo->format('Y-m-d');
		}
		if (isset($this->dateFromLessThanOrEqualTo)) {
			$array['date_from__lte'] = $this->dateFromLessThanOrEqualTo->format('Y-m-d');
		}
		if (isset($this->dateToGreaterThanOrEqualTo)) {
			$array['date_to__gte'] = $this->dateToGreaterThanOrEqualTo->format('Y-m-d');
		}
		if (isset($this->dateToLessThanOrEqualTo)) {
			$array['date_to__lte'] = $this->dateToLessThanOrEqualTo->format('Y-m-d');
		}

		return $array;
	}

}
