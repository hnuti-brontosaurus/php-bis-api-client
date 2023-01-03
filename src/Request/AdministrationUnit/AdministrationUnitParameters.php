<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Request\AdministrationUnit;

use HnutiBrontosaurus\BisClient\Enums\AdministrationUnitCategory;
use HnutiBrontosaurus\BisClient\Request\ToArray;


final class AdministrationUnitParameters implements ToArray
{

	public function __construct()
	{}


	// categories

	/** @var AdministrationUnitCategory[] */
	private array $categories = [];

	public function setCategory(AdministrationUnitCategory $category): self
	{
		$this->categories = [$category];
		return $this;
	}

	/**
	 * @param AdministrationUnitCategory[] $categories
	 */
	public function setCategories(array $categories): self
	{
		$this->categories = $categories;
		return $this;
	}


	// getters

	public function toArray(): array
	{
		$array = [];

		if (\count($this->categories) > 0) {
			$array['category'] = \implode(',', $this->categories);
		}

		return $array;
	}

}
