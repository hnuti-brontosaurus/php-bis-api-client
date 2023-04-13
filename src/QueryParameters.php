<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;

use Stringable;


interface QueryParameters
{

	public function getLimit(): ?int;

	/** @return array<scalar|Stringable> */
	public function toArray(): array;

}
