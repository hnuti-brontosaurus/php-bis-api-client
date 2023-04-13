<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;

use function sprintf;


/**
 * Limit parameter is not appended to request as API doesn't support it.
 * It is applied when processing response.
 */
trait LimitParameter
{

	private ?int $limit = null;

	public function setLimit(?int $limit): self
	{
		if ($limit !== null) {
			if ($limit === 0) {
				throw new UsageException("Limit must be at least 1. If you want to remove limit, use 'removeLimit()' method");

			} elseif ($limit < 1) {
				throw new UsageException(sprintf("Limit must be at least 1, '%d' given", $limit));
			}
		}

		$this->limit = $limit;
		return $this;
	}

	public function removeLimit(): self
	{
		$this->limit = null;
		return $this;
	}

	public function getLimit(): ?int
	{
		return $this->limit;
	}

}
