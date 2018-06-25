<?php

namespace HnutiBrontosaurus\BisApiClient;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;
use HnutiBrontosaurus\BisApiClient\Request\EventParameters;
use HnutiBrontosaurus\BisApiClient\Request\OrganizationalUnitParameters;
use HnutiBrontosaurus\BisApiClient\Request\Parameters;
use HnutiBrontosaurus\BisApiClient\Response\Event;
use HnutiBrontosaurus\BisApiClient\Response\OrganizationalUnit;
use HnutiBrontosaurus\BisApiClient\Response\Response;


final class Client
{

	/** @var string */
	private $url;

	/** @var string */
	private $username;

	/** @var string */
	private $password;


	/**
	 * @param string $url
	 * @param string $username
	 * @param string $password
	 */
	public function __construct($url, $username, $password)
	{
		if ($url === '') {
			throw new InvalidArgumentException('You need to pass an URL with BIS API.');
		}
		if ($username === '') {
			throw new InvalidArgumentException('Username is required for authenticating against BIS.');
		}
		if ($password === '') {
			throw new InvalidArgumentException('Password is required for authenticating against BIS.');
		}

		$this->url = \rtrim($url, '/');
		$this->username = $username;
		$this->password = $password;
	}


	/**
	 * @param int $id
	 * @param EventParameters $params
	 * @return Event
	 * @throws BisClientException
	 * @throws GuzzleException
	 * @throws ResourceNotFoundException
	 */
	public function getEvent($id, EventParameters $params = NULL)
	{
		$params = ($params !== NULL ? $params : new EventParameters());
		$params->setId($id);
		$response = $this->processRequest($params);

		$data = $response->getData();

		if (\count($data) === 0) {
			throw new BisClientException('No result for event with id `' . $id . '`.');
		}

		return Event::fromResponseData(\reset($data));
	}

	/**
	 * @param EventParameters $params
	 * @return Event[]
	 * @throws BisClientException
	 * @throws GuzzleException
	 * @throws ResourceNotFoundException
	 */
	public function getEvents(EventParameters $params = NULL)
	{
		$response = $this->processRequest($params !== NULL ? $params : new EventParameters());
		return \array_map(Event::class . '::fromResponseData', $response->getData());
	}

	/**
	 * @param OrganizationalUnitParameters $params
	 * @return OrganizationalUnit[]
	 * @throws BisClientException
	 * @throws GuzzleException
	 * @throws ResourceNotFoundException
	 */
	public function getOrganizationalUnits(OrganizationalUnitParameters $params = NULL)
	{
		$response = $this->processRequest($params !== NULL ? $params : new OrganizationalUnitParameters());
		return \array_map(OrganizationalUnit::class . '::fromResponseData', $response->getData());
	}


	/**
	 * @param Parameters $requestParameters
	 * @return Response
	 * @throws BisClientException
	 * @throws GuzzleException
	 * @throws ResourceNotFoundException
	 */
	private function processRequest(Parameters $requestParameters)
	{
		$requestParameters->setCredentials($this->username, $this->password);

		$httpClient = new HttpClient();
		$httpRequest = new Request('POST', $this->buildUrl($requestParameters));

		try {
			$response = $httpClient->send($httpRequest);

		} catch (ClientException $e) {
			throw new ResourceNotFoundException('Bis client could not find the queried resource.', 0, $e);

		} catch (TransferException $e) {
			throw new BisClientException('Unable to process request: transfer error.', 0, $e);
		}

		if (\strncmp($response->getHeaderLine('Content-Type'), 'text/xml', \strlen('text/xml')) !== 0) {
			throw new BisClientException('Unable to process response: the response Content-Type is invalid or missing.');
		}

		try {
			$domDocument = new \DOMDocument();
			$domDocument->loadXML($response->getBody());

		} catch (\Exception $e) {
			throw new BisClientException('Unable to process response: response body contains invalid XML.', 0, $e);
		}

		$resultNode = $domDocument->getElementsByTagName(Response::TAG_RESULT)->item(0);
		if ($resultNode->hasAttribute(Response::TAG_RESULT_ATTRIBUTE_ERROR)) {
			switch ($resultNode->getAttribute(Response::TAG_RESULT_ATTRIBUTE_ERROR)) {
				case 'forbidden':
					throw new BisClientException('You are not authorized to make such request with given credentials. Or you have simply wrong credentials. :-)');
					break;

				case 'params':
					throw new BisClientException('Parameters are invalid.');
					break;

				default:
					throw new BisClientException('Unknown error. Error type returned from BIS: `' . $resultNode->getAttribute(Response::TAG_RESULT_ATTRIBUTE_ERROR) . '`');
					break;
			}
		}

		return new Response($response, $domDocument);
	}

	/**
	 * @param Parameters $params
	 * @return string
	 */
	private function buildUrl(Parameters $params)
	{
		$queryString = $params->getQueryString();
		return $this->url . ($queryString !== '' ? '?' . $queryString : '');
	}

}
