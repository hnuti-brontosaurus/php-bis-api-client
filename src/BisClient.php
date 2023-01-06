<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;

use HnutiBrontosaurus\BisClient\Request\AdministrationUnit\AdministrationUnitParameters;
use HnutiBrontosaurus\BisClient\Request\Event\EventParameters;
use HnutiBrontosaurus\BisClient\Request\Opportunity\OpportunityParameters;
use HnutiBrontosaurus\BisClient\Request\QueryParameters;
use HnutiBrontosaurus\BisClient\Response\AdministrationUnit\AdministrationUnit;
use HnutiBrontosaurus\BisClient\Response\Event\Event;
use HnutiBrontosaurus\BisClient\Response\Opportunity\Opportunity;


final class BisClient
{

	public function __construct(
		private HttpClient $httpClient,
	) {}


	// events

	/**
	 * @return Event[]
	 * @throws ConnectionToBisFailed
	 */
	public function getEvents(?EventParameters $params = null): array
	{
		$params = $params !== null ? $params : new EventParameters();
		$events = $this->retrieve(Endpoint::EVENTS(), $params, $params->getLimit());
		return \array_map(static fn($result) => Event::fromResponseData($result), $events);
	}


	/**
	 * @throws NotFound
	 * @throws ConnectionToBisFailed
	 */
	public function getEvent(int $id): Event
	{
		$data = $this->httpClient->send('GET', Endpoint::EVENT($id));
		return Event::fromResponseData($data);
	}


	// administration units

	/**
	 * @return AdministrationUnit[]
	 * @throws ConnectionToBisFailed
	 */
	public function getAdministrationUnits(?AdministrationUnitParameters $params = null): array
	{
		$params = $params !== null ? $params : new AdministrationUnitParameters();
		$administrationUnits = $this->retrieve(Endpoint::ADMINISTRATION_UNITS(), $params, $params->getLimit());
		return \array_map(static fn($result) => AdministrationUnit::fromResponseData($result), $administrationUnits);
	}


	// opportunities

	/**
	 * @return Opportunity[]
	 * @throws ConnectionToBisFailed
	 */
	public function getOpportunities(?OpportunityParameters $params = null): array
	{
		$params = $params !== null ? $params : new OpportunityParameters();
		$opportunities = $this->retrieve(Endpoint::OPPORTUNITIES(), $params, $params->getLimit());
		return \array_map(static fn($result) => Opportunity::fromResponseData($result), $opportunities);
	}


	/**
	 * @throws NotFound
	 * @throws ConnectionToBisFailed
	 */
	public function getOpportunity(int $id): Opportunity
	{
		$data = $this->httpClient->send('GET', Endpoint::OPPORTUNITY($id));
		return Opportunity::fromResponseData($data);
	}


	/**
	 * Generic method for obtaining data regardless of API pagination
	 * @param int $currentCount @internal
	 * @return array<mixed> raw data
	 * @throws ConnectionToBisFailed
	 */
	private function retrieve(string $endpoint, ?QueryParameters $params, ?int $limit, int $currentCount = 0, bool $topLevel = true): array
	{
		/** @var array{count: int, next: ?string, previous: ?string, results: array<mixed>} $data */
		$data = $this->httpClient->send('GET', $endpoint, $params);
		$results = $data['results'];

		// request more results if limit is not reached yet
		if (($limit === null xor $currentCount < $limit) && $data['next'] !== null) {
			$moreResults = $this->retrieve(
				endpoint: $data['next'],
				params: null, // params are already included in next URL
				limit: $limit,
				currentCount: $currentCount + \count($results),
				topLevel: false,
			);
			$results = [...$results, ...$moreResults];
		}

		// keep only given count of data
		if ($topLevel && $limit !== null) {
			$results = \array_slice($results, 0, $limit);
		}

		return $results;
	}


	// misc

	public function getLastRequestUrl(): ?string
	{
		return $this->httpClient->getLastRequestUrl();
	}


	/** @return array<mixed>|string|null */
	public function getLastResponse(): array|string|null
	{
		return $this->httpClient->getLastResponse();
	}

}
