<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use function rtrim;


/*
 * We can not count on using dependency injection container in applications using this library.
 * But we can say that BisClientFactory should be called only once per request,
 * so we build dependencies here in constructor.
 *
 */
final class BisClientFactory
{

	private Client $underlyingHttpClient;

	public function __construct(string $apiUrl)
	{
		$stack = HandlerStack::create();
		$stack->push(self::lastRequestUrlIntoHeaderMiddleware());
		$this->underlyingHttpClient = new Client([
			'base_uri' => rtrim($apiUrl, '/') . '/',
			'handler' => $stack,
		]);
	}


	/**
	 * @throws ConnectionToBisFailed
	 */
	public function create(): BisClient
	{
		return new BisClient(
			new HttpClient($this->underlyingHttpClient, self::LAST_REQUEST_URL_HEADER_KEY),
		);
	}


	public const LAST_REQUEST_URL_HEADER_KEY = 'X-Bronto-Last-Request-Url';

	/**
	 * Stores last request url into response header
	 * source: https://docs.guzzlephp.org/en/stable/handlers-and-middleware.html#middleware
	 */
	private static function lastRequestUrlIntoHeaderMiddleware(): callable
	{
		return function (callable $handler) {
			return function (RequestInterface $request, array $options) use ($handler) {
				return ($handler)($request, $options)
					->then(fn(ResponseInterface $response) => $response->withAddedHeader(self::LAST_REQUEST_URL_HEADER_KEY, (string) $request->getUri()));
			};
		};
	}

}
