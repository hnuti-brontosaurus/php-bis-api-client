<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Event\Response;


final readonly class Tag
{

	private function __construct(
		public int $id,
		public string $name,
		public string $slug,
		public string $description,
		public bool $isActive,
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

}
