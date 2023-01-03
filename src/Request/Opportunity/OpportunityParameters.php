<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Request\Opportunity;

use HnutiBrontosaurus\BisClient\Enums\OpportunityCategory;
use HnutiBrontosaurus\BisClient\Request\ToArray;


final class OpportunityParameters implements ToArray
{

	public function __construct()
	{}


	// categories

	/** @var OpportunityCategory[] */
	private array $categories = [];

	public function setCategory(OpportunityCategory $category): self
	{
		$this->categories = [$category];
		return $this;
	}

	/**
	 * @param OpportunityCategory[] $categories
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
