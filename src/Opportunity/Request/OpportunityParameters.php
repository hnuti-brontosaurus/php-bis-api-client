<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Opportunity\Request;

use HnutiBrontosaurus\BisClient\LimitParameter;
use HnutiBrontosaurus\BisClient\Opportunity\Category;
use HnutiBrontosaurus\BisClient\QueryParameters;
use function count;
use function implode;


final class OpportunityParameters implements QueryParameters
{
	use LimitParameter;

	public function __construct()
	{}


	// categories

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


	// getters

	public function toArray(): array
	{
		$array = [];

		if (count($this->categories) > 0) {
			$array['category'] = implode(',', $this->categories);
		}

		return $array;
	}

}
