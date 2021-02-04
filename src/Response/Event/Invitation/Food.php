<?php

namespace HnutiBrontosaurus\BisApiClient\Response\Event\Invitation;


final class Food
{

	/* private */ const CHOOSEABLE = 0;
	/* private */ const VEGETARIAN = 1;
	/* private */ const NON_VEGETARIAN = 2;


	/** @var bool */
	private $isListed = false;

	/** @var bool */
	private $isOfTypeChooseable = false;

	/** @var bool */
	private $isOfTypeVegetarian = false;

	/** @var bool */
	private $isOfTypeNonVegetarian = false;


	/**
	 * @param int|null $food
	 */
	private function __construct($food)
	{
		if (\in_array($food, [
			self::CHOOSEABLE,
			self::VEGETARIAN,
			self::NON_VEGETARIAN,
		], true)) {
			$this->isListed = true;

			$this->isOfTypeChooseable = $food === self::CHOOSEABLE;
			$this->isOfTypeVegetarian = $food === self::VEGETARIAN;
			$this->isOfTypeNonVegetarian = $food === self::NON_VEGETARIAN;
		}
	}

	/**
	 * @param int|null $food
	 * @return self
	 */
	public static function from($food)
	{
		return new self($food);
	}


	/**
	 * @return bool
	 */
	public function isListed()
	{
		return $this->isListed;
	}

	/**
	 * @return bool
	 */
	public function isOfTypeChooseable()
	{
		return $this->isOfTypeChooseable;
	}

	/**
	 * @return bool
	 */
	public function isOfTypeVegetarian()
	{
		return $this->isOfTypeVegetarian;
	}

	/**
	 * @return bool
	 */
	public function isOfTypeNonVegetarian()
	{
		return $this->isOfTypeNonVegetarian;
	}

}
