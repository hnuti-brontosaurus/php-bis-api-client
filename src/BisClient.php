<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;

use HnutiBrontosaurus\BisClient\Request\Event\EventParameters;
use HnutiBrontosaurus\BisClient\Request\OpportunityParameters;
use HnutiBrontosaurus\BisClient\Response\Event\Event;
use HnutiBrontosaurus\BisClient\Response\Opportunity;
use HnutiBrontosaurus\BisClient\Response\OrganizationalUnit\OrganizationalUnit;


final class BisClient
{

	public function __construct(
		private HttpClient $httpClient,
	) {}


	// events

	/**
	 * @throws NotFound
	 * @throws ConnectionToBisFailed
	 */
	public function getEvent(int $id): Event
	{
		$response = $this->httpClient->send('GET', Endpoint::EVENT($id));
		return Event::fromResponseData($response);
	}


	/**
	 * @return Event[]
	 * @throws ConnectionToBisFailed
	 */
	public function getEvents(?EventParameters $params = null): array
	{
		$data = $this->httpClient->send(
			'GET', Endpoint::EVENTS(),
			$params !== null
				? $params
				: new EventParameters(),
		);
		return \array_map(Event::class . '::fromResponseData', $data['results']);
	}


	// organizational units

	/**
	 * @return OrganizationalUnit[]
	 * @throws ConnectionToBisFailed
	 */
	public function getOrganizationalUnits(): array
	{
		$data = $this->httpClient->send('GET', Endpoint::ADMINISTRATIVE_UNITS());
		return \array_map(OrganizationalUnit::class . '::fromResponseData', $data);
	}


	/**
	 * @return Opportunity[]
	 */
	public function getOpportunities(?OpportunityParameters $params = null): array
	{
		$data = $this->httpClient->send('GET', Endpoint::OPPORTUNITIES(), $params !== null ? $params : new OpportunityParameters());

		if ($data === null) {
			return [];
		}

		\assert(\is_array($data->results));
		return \array_map(Opportunity::class . '::fromResponseData', $data->results);
	}


	/**
	 * @throws NotFound
	 * @throws ConnectionToBisFailed
	 */
	public function getOpportunity(int $id): Opportunity
	{
		$data = $this->httpClient->send('GET', Endpoint::OPPORTUNITY($id));

		\assert($data instanceof \stdClass);
		return Opportunity::fromResponseData($data);
	}


	// adoption

	// not yet implemented
//	public function saveRequestForAdoption(Adoption $adoption): void
//	{}

}
