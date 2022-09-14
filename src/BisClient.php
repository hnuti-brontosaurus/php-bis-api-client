<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;

use HnutiBrontosaurus\BisClient\Request\Event\EventParameters;
use HnutiBrontosaurus\BisClient\Response\Event\Event;
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


	// adoption

	// not yet implemented
//	public function saveRequestForAdoption(Adoption $adoption): void
//	{}

}
