<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Response;


final class Tag
{

	private function __construct(
		private int $id,
		private string $name,
		private string $slug,
		private string $description,
		private bool $isActive,
	) {}


	/**
	 * @param array{
	 *     id: int,
	 *     name: string,
	 *     slug: string,
	 *     description: string,
	 *     is_active: bool,
	 * } $payload
	 */
	public static function fromPayload(array $payload): self
	{
		return new self(
			$payload['id'],
			$payload['name'],
			$payload['slug'],
			$payload['description'],
			$payload['is_active'],
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


	public function getSlug(): string
	{
		return $this->slug;
	}


	public function getDescription(): string
	{
		return $this->description;
	}


	public function isActive(): bool
	{
		return $this->isActive;
	}

}
