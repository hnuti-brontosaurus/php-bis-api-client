<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;

use GuzzleHttp\Client;


/*
 * We can not count on using dependency injection container in applications using this library.
 * But we can say that BisClientFactory should be called only once per request,
 * so we build dependencies here in constructor.
 *
 */
final class BisClientFactory
{

	private Client $httpClient;

	public function __construct(string $apiUrl)
	{
		$this->httpClient = new Client(['base_uri' => \rtrim($apiUrl, '/') . '/']);
	}


	/**
	 * @throws UnableToAuthorize
	 * @throws ConnectionToBisFailed
	 */
	public function create(): BisClient
	{
		return new BisClient(
			new HttpClient($this->httpClient),
		);
	}

}
