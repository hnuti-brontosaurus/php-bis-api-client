<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;

use HnutiBrontosaurus\BisClient\AdministrationUnit\Request\AdministrationUnitParameters as AdministrationUnitParameters;
use HnutiBrontosaurus\BisClient\AdministrationUnit\Response\AdministrationUnit;
use HnutiBrontosaurus\BisClient\Event\Request\EventParameters as EventParameters;
use HnutiBrontosaurus\BisClient\Event\Response\Event;
use HnutiBrontosaurus\BisClient\Opportunity\Request\OpportunityParameters as OpportunityParameters;
use HnutiBrontosaurus\BisClient\Opportunity\Response\Opportunity;


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
	 * @throws EventNotFound
	 * @throws ConnectionToBisFailed
	 */
	public function getEvent(int $id): Event
	{
		try {
			$data = $this->httpClient->send('GET', Endpoint::EVENT($id));

		} catch (NotFound $e) {
			throw new EventNotFound(previous: $e);

		} catch (ConnectionError $e) {
			throw new ConnectionToBisFailed(previous: $e);
		}

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
	 * @throws OpportunityNotFound
	 * @throws ConnectionToBisFailed
	 */
	public function getOpportunity(int $id): Opportunity
	{
		try {
			$data = $this->httpClient->send('GET', Endpoint::OPPORTUNITY($id));

		} catch (NotFound $e) {
			throw new OpportunityNotFound(previous: $e);

		} catch (ConnectionError $e) {
			throw new ConnectionToBisFailed(previous: $e);
		}

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
		try {
			/** @var array{count: int, next: ?string, previous: ?string, results: array<mixed>} $data */
			$data = $this->httpClient->send('GET', $endpoint, $params);
			$results = $data['results'];

		} catch (ConnectionError $e) {
			throw new ConnectionToBisFailed(previous: $e);
		}

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
