<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;

use HnutiBrontosaurus\BisClient\Request\AdministrationUnit\AdministrationUnitParameters;
use HnutiBrontosaurus\BisClient\Request\Event\EventParameters;
use HnutiBrontosaurus\BisClient\Request\Opportunity\OpportunityParameters;
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
		/** @var array{results: array<mixed>} $data */
		$data = $this->httpClient->send(
			'GET', Endpoint::EVENTS(),
			$params !== null
				? $params
				: new EventParameters(),
		);
		return \array_map(static fn($result) => Event::fromResponseData($result), $data['results']);
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
		/** @var array{results: array<mixed>} $data */
		$data = $this->httpClient->send('GET', Endpoint::ADMINISTRATION_UNITS(), $params !== null ? $params : new AdministrationUnitParameters());
		return \array_map(static fn($result) => AdministrationUnit::fromResponseData($result), $data['results']);
	}


	// opportunities

	/**
	 * @return Opportunity[]
	 */
	public function getOpportunities(?OpportunityParameters $params = null): array
	{
		/** @var array{results: array<mixed>} $data */
		$data = $this->httpClient->send('GET', Endpoint::OPPORTUNITIES(), $params !== null ? $params : new OpportunityParameters());
		return \array_map(static fn($result) => Opportunity::fromResponseData($result), $data['results']);
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

}
