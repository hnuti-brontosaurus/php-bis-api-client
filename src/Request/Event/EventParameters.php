<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Request\Event;

use HnutiBrontosaurus\BisClient\Enums\EventCategory;
use HnutiBrontosaurus\BisClient\Enums\EventGroup;
use HnutiBrontosaurus\BisClient\Enums\Program;
use HnutiBrontosaurus\BisClient\Enums\IntendedFor;
use HnutiBrontosaurus\BisClient\Request\ToArray;


final class EventParameters implements ToArray
{

	public function __construct()
	{}



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


	// getters

	public function toArray(): array
	{
		$array = [];

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

		return $array;
	}

}
