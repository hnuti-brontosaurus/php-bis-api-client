<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Response;

use HnutiBrontosaurus\BisClient\Response\ContactPerson;


final class Propagation
{

	/**
	 * @param Diet[] $diets
	 * @param Image[] $images
	 */
	private function __construct(
		private ?int $minimumAge,
		private ?int $maximumAge,
		private string $cost,
		private string $accommodation,
		private ?int $workingDays,
		private ?int $workingHours,
		private array $diets,
		private ?string $organizers,
		private ?string $webUrl,
		private string $invitationTextIntroduction,
		private string $invitationTextPracticalInformation,
		private ?string $invitationTextWorkDescription,
		private ?string $invitationTextAboutUs,
		private ContactPerson $contactPerson,
		private array $images,
	) {}


	/**
	 * @param Diet[] $diets
	 * @param Image[] $images
	 */
	public static function from(
		?int $minimumAge,
		?int $maximumAge,
		string $cost,
		string $accommodation,
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


	public function getMinimumAge(): ?int
	{
		return $this->minimumAge;
	}


	public function getMaximumAge(): ?int
	{
		return $this->maximumAge;
	}


	public function getCost(): string
	{
		return $this->cost;
	}


	public function getAccommodation(): string
	{
		return $this->accommodation;
	}


	public function getWorkingDays(): ?int
	{
		return $this->workingDays;
	}


	public function getWorkingHours(): ?int
	{
		return $this->workingHours;
	}


	/**
	 * @return Diet[]
	 */
	public function getDiets(): array
	{
		return $this->diets;
	}


	public function getOrganizers(): ?string
	{
		return $this->organizers;
	}


	public function getWebUrl(): ?string
	{
		return $this->webUrl;
	}


	public function getInvitationTextIntroduction(): string
	{
		return $this->invitationTextIntroduction;
	}


	public function getInvitationTextPracticalInformation(): string
	{
		return $this->invitationTextPracticalInformation;
	}


	public function getInvitationTextWorkDescription(): ?string
	{
		return $this->invitationTextWorkDescription;
	}


	public function getInvitationTextAboutUs(): ?string
	{
		return $this->invitationTextAboutUs;
	}


	public function getContactPerson(): ContactPerson
	{
		return $this->contactPerson;
	}


	/**
	 * @return Image[]
	 */
	public function getImages(): array
	{
		return $this->images;
	}

}
