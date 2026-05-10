<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Response;

use HnutiBrontosaurus\BisClient\Response\ContactPerson;
use HnutiBrontosaurus\BisClient\Response\Image;


final readonly class Propagation
{

	/**
	 * @param Diet[] $diets
	 * @param Image[] $images
	 */
	private function __construct(
		public ?int $minimumAge,
		public ?int $maximumAge,
		public string $cost,
		public ?string $accommodation,
		public ?int $workingDays,
		public ?int $workingHours,
		public array $diets,
		public ?string $organizers,
		public ?string $webUrl,
		public string $invitationTextIntroduction,
		public string $invitationTextPracticalInformation,
		public ?string $invitationTextWorkDescription,
		public ?string $invitationTextAboutUs,
		public ContactPerson $contactPerson,
		public array $images,
	) {}


	/**
	 * @param Diet[] $diets
	 * @param Image[] $images
	 */
	public static function from(
		?int $minimumAge,
		?int $maximumAge,
		string $cost,
		?string $accommodation,
		?int $workingDays,
		?int $workingHours,
		array $diets,
		?string $organizers,
		?string $webUrl,
		string $introduction,
		string $practicalInformation,
		?string $workDescription,
		?string $aboutUs,
		ContactPerson $contactPerson,
		array $images,
	): self
	{
		return new self(
			$minimumAge,
			$maximumAge,
			$cost,
			$accommodation,
			$workingDays,
			$workingHours,
			$diets,
			$organizers,
			$webUrl,
			$introduction,
			$practicalInformation,
			$workDescription,
			$aboutUs,
			$contactPerson,
			$images,
		);
	}

}
