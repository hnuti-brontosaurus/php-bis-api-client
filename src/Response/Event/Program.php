<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisApiClient\Response\Event;


final class Program
{

	const PROGRAM_NONE = 'none';
	const PROGRAM_NATURE = 'ap';
	const PROGRAM_SIGHTS = 'pamatky';
	const PROGRAM_BRDO = 'brdo';
	const PROGRAM_EKOSTAN = 'ekostan';
	const PROGRAM_PSB = 'psb';
	const PROGRAM_EDUCATION = 'vzdelavani';


	private function __construct(
		private string $slug,
		private ?string $name,
	) {}


	public static function from(
		?string $slug,
		?string $name,
	): self
	{
		if ($slug === null) {
			$slug = self::PROGRAM_NONE;
		}

		if ( ! \in_array($slug, [
			self::PROGRAM_NONE,
			self::PROGRAM_NATURE,
			self::PROGRAM_SIGHTS,
			self::PROGRAM_BRDO,
			self::PROGRAM_EKOSTAN,
			self::PROGRAM_PSB,
			self::PROGRAM_EDUCATION,
		], true)) {
			$slug = self::PROGRAM_NONE;
		}

		return new self($slug, $name);
	}


	public function getSlug(): string
	{
		return $this->slug;
	}


	public function getName(): ?string
	{
		return $this->name;
	}


	public function isNotSelected(): bool
	{
		return $this->slug === self::PROGRAM_NONE;
	}


	public function isOfTypeNature(): bool
	{
		return $this->slug === self::PROGRAM_NATURE;
	}


	public function isOfTypeSights(): bool
	{
		return $this->slug === self::PROGRAM_SIGHTS;
	}


	public function isOfTypeBrdo(): bool
	{
		return $this->slug === self::PROGRAM_BRDO;
	}


	public function isOfTypeEkostan(): bool
	{
		return $this->slug === self::PROGRAM_EKOSTAN;
	}


	public function isOfTypePsb(): bool
	{
		return $this->slug === self::PROGRAM_PSB;
	}


	public function isOfTypeEducation(): bool
	{
		return $this->slug === self::PROGRAM_EDUCATION;
	}

}
