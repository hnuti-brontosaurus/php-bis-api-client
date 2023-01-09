<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Exception\TooManyRedirectsException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\NetworkExceptionInterface;


final class HttpClient
{

	public function __construct(
		private Client $client,
		private string $lastRequestUrlHeaderKey,
	) {}


	/**
	 * @return array<mixed>
	 * @throws NotFound
	 * @throws ConnectionError
	 */
	public function send(
		string $method,
		string $endpoint,
		?QueryParameters $queryParameters = null,
	): array
	{
		$queryString = $queryParameters !== null
			? '?' . \http_build_query($queryParameters->toArray())
			: '';

		// see Guzzle exceptions docs: https://docs.guzzlephp.org/en/stable/quickstart.html#exceptions
		try {
			$response = $this->client->send(new Request(
				$method,
				$endpoint . $queryString,
				[
					'Content-Type' => 'application/json',
				],
			));

		} catch (ClientException $e) { // 4xx errors
			if ($e->getCode() === 404) {
				throw NotFound::withPrevious($e);
			}

			throw ConnectionError::withPrevious($e);

		} catch (ServerException $e) { // 5xx errors
			throw ConnectionError::withPrevious($e);

		} catch (TooManyRedirectsException $e) {
			throw ConnectionError::withPrevious($e);

		} catch (NetworkExceptionInterface $e) { // problem with connection
			throw ConnectionError::withPrevious($e);

		} catch (GuzzleException $e) { // fallback catch-all exception
			throw ConnectionError::withPrevious($e);
		}

		$this->lastRequestUrl = $response->hasHeader($this->lastRequestUrlHeaderKey) ? $response->getHeader($this->lastRequestUrlHeaderKey)[0] : null;

		$content = $response->getBody()->getContents();
		$this->lastResponseEncoded = $content;
		$decoded = \json_decode($content, flags: JSON_OBJECT_AS_ARRAY);
		\assert(\is_array($decoded));
		$this->lastResponseDecoded = $decoded;
		return $decoded;
	}

	private ?string $lastRequestUrl = null;

	public function getLastRequestUrl(): ?string
	{
		return $this->lastRequestUrl;
	}

	private ?string $lastResponseEncoded = null;
	/** @var array<mixed>|null */
	private ?array $lastResponseDecoded = null;

	/** @return array<mixed>|string|null */
	public function getLastResponse(): array|string|null
	{
		return $this->lastResponseDecoded !== null
			? $this->lastResponseDecoded
			: $this->lastResponseEncoded;
	}

}
