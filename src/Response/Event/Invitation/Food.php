<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisApiClient\Response\Event\Invitation;


final class Food
{

	private const CHOOSEABLE = 0;
	private const VEGETARIAN = 1;
	private const NON_VEGETARIAN = 2;

	private bool $isListed = false;
	private bool $isOfTypeChooseable = false;
	private bool $isOfTypeVegetarian = false;
	private bool $isOfTypeNonVegetarian = false;


	private function __construct(?int $food)
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


	public static function from(?int $food): self
	{
		return new self($food);
	}


	public function isListed(): bool
	{
		return $this->isListed;
	}


	public function isOfTypeChooseable(): bool
	{
		return $this->isOfTypeChooseable;
	}


	public function isOfTypeVegetarian(): bool
	{
		return $this->isOfTypeVegetarian;
	}


	public function isOfTypeNonVegetarian(): bool
	{
		return $this->isOfTypeNonVegetarian;
	}

}
