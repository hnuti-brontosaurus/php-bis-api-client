<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response;

use HnutiBrontosaurus\BisClient\Enums\OpportunityCategory;
use HnutiBrontosaurus\BisClient\Response\Event\ContactPerson;


final class Opportunity
{

	private function __construct(
		private int $id,
		private string $name,
		private OpportunityCategory $category,
		private \DateTimeImmutable $dateStart,
		private \DateTimeImmutable $dateEnd,
		private Location $location,
		private Html $introduction,
		private Html $description,
		private ?Html $locationBenefits,
		private Html $personalBenefits,
		private Html $requirements,
		private ContactPerson $contactPerson,
		private Image $image,
	) {}

	public static function fromResponseData(\stdClass $data): self
	{
		return new self(
			$data->id,
			$data->name,
			OpportunityCategory::fromScalar($data->category->slug),
			\DateTimeImmutable::createFromFormat('Y-m-d', $data->start),
			\DateTimeImmutable::createFromFormat('Y-m-d', $data->end),
			Location::from($data->location->name, $data->location->gps_location !== null
				? Coordinates::from(
					$data->location->gps_location->coordinates[1],
					$data->location->gps_location->coordinates[0],
				)
				: null),
			Html::of($data->introduction),
			Html::of($data->description),
			$data->location_benefits !== '' ? Html::of($data->location_benefits) : null,
			Html::of($data->personal_benefits),
			Html::of($data->requirements),
			ContactPerson::from(
				$data->contact_name,
				$data->contact_email,
				$data->contact_phone, // todo nullability?
			),
			Image::from((array) $data->image),
		);
	}


	public function getId(): int
	{
		return $this->id;
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getCategory(): OpportunityCategory
	{
		return $this->category;
	}


	public function getDateStart(): \DateTimeImmutable
	{
		return $this->dateStart;
	}


	public function getDateEnd(): \DateTimeImmutable
	{
		return $this->dateEnd;
	}


	public function getLocation(): Location
	{
		return $this->location;
	}


	public function getIntroduction(): Html
	{
		return $this->introduction;
	}


	public function getDescription(): Html
	{
		return $this->description;
	}


	public function getLocationBenefits(): ?Html
	{
		return $this->locationBenefits;
	}


	public function getPersonalBenefits(): Html
	{
		return $this->personalBenefits;
	}


	public function getRequirements(): Html
	{
		return $this->requirements;
	}


	public function getContactPerson(): ContactPerson
	{
		return $this->contactPerson;
	}


	public function getImage(): Image
	{
		return $this->image;
	}

}
