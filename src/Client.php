<?php

namespace HnutiBrontosaurus\BisApiClient;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;
use HnutiBrontosaurus\BisApiClient\Request\EventAttendee;
use HnutiBrontosaurus\BisApiClient\Request\EventParameters;
use HnutiBrontosaurus\BisApiClient\Request\OrganizationalUnitParameters;
use HnutiBrontosaurus\BisApiClient\Request\Parameters;
use HnutiBrontosaurus\BisApiClient\Response\Event\Event;
use HnutiBrontosaurus\BisApiClient\Response\OrganizationalUnit\OrganizationalUnit;
use HnutiBrontosaurus\BisApiClient\Response\Response;
use Psr\Http\Message\ResponseInterface;


final class Client
{

	/** @var HttpClient */
	private $httpClient;

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
	 * @param HttpClient $httpClient
	 */
	public function __construct($url, $username, $password, HttpClient $httpClient)
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
		$this->httpClient = $httpClient;
	}


	// events

	/**
	 * @param int $id
	 * @param EventParameters $params
	 * @return Event
	 * @throws BisClientException
	 * @throws GuzzleException
	 * @throws ResourceNotFoundException
	 */
	public function getEvent($id, EventParameters $params = null)
	{
		$params = ($params !== null ? $params : new EventParameters());
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
	public function getEvents(EventParameters $params = null)
	{
		$response = $this->processRequest($params !== null ? $params : new EventParameters());
		$data = $response->getData();

		if ($data === null) {
			return [];
		}

		return \array_map(Event::class . '::fromResponseData', $data);
	}

	/**
	 * @param EventAttendee $eventAttendee
	 * @throws ResponseErrorException
	 * @throws BisClientException
	 */
	public function addAttendeeToEvent(EventAttendee $eventAttendee)
	{
		$eventAttendee->setCredentials($this->username, $this->password);
		$response = $this->httpClient->post($this->buildUrl($eventAttendee), $this->convertArrayToFormData($eventAttendee->getData()));

		$this->checkForResponseContentType($response);

		$domDocument = $this->generateDOM($response);
		$this->checkForResponseErrors($domDocument);
	}


	// organizational units

	/**
	 * @param OrganizationalUnitParameters $params
	 * @return OrganizationalUnit[]
	 * @throws BisClientException
	 * @throws GuzzleException
	 * @throws ResourceNotFoundException
	 */
	public function getOrganizationalUnits(OrganizationalUnitParameters $params = null)
	{
		$response = $this->processRequest($params !== null ? $params : new OrganizationalUnitParameters());
		return \array_map(OrganizationalUnit::class . '::fromResponseData', $response->getData());
	}


	/**
	 * @param Parameters $requestParameters
	 * @return Response
	 * @throws ResponseErrorException
	 * @throws BisClientException
	 * @throws GuzzleException
	 * @throws ResourceNotFoundException
	 */
	private function processRequest(Parameters $requestParameters)
	{
		$requestParameters->setCredentials($this->username, $this->password);

		$httpRequest = new Request('POST', $this->buildUrl($requestParameters));

		try {
			$response = $this->httpClient->send($httpRequest);

		} catch (ClientException $e) {
			throw new ResourceNotFoundException('Bis client could not find the queried resource.', 0, $e);

		} catch (TransferException $e) {
			throw new BisClientException('Unable to process request: transfer error.', 0, $e);
		}

		$this->checkForResponseContentType($response);

		$domDocument = $this->generateDOM($response);
		$this->checkForResponseErrors($domDocument);

		return new Response($response, $domDocument);
	}


	/**
	 * @param ResponseInterface $response
	 * @throws BisClientException
	 */
	private function checkForResponseContentType(ResponseInterface $response)
	{
		if (\strncmp($response->getHeaderLine('Content-Type'), 'text/xml', \strlen('text/xml')) !== 0) {
			throw new BisClientException('Unable to process response: the response Content-Type is invalid or missing.');
		}
	}

	/**
	 * @param ResponseInterface $response
	 * @return \DOMDocument
	 * @throws BisClientException
	 */
	private function generateDOM(ResponseInterface $response)
	{
		try {
			$domDocument = new \DOMDocument();
			$domDocument->loadXML($response->getBody());

		} catch (\Exception $e) {
			throw new BisClientException('Unable to process response: response body contains invalid XML.', 0, $e);
		}

		return $domDocument;
	}

	/**
	 * @param \DOMDocument $domDocument
	 * @throws ResponseErrorException
	 */
	private function checkForResponseErrors(\DOMDocument $domDocument)
	{
		$resultNode = $domDocument->getElementsByTagName(Response::TAG_RESULT)->item(0);
		if ($resultNode->hasAttribute(Response::TAG_RESULT_ATTRIBUTE_ERROR)) {
			switch ($resultNode->getAttribute(Response::TAG_RESULT_ATTRIBUTE_ERROR)) {
				case 'success': // In case of POST request with form data, BIS returns `<result error="success" />` for some reason... Let's pretend that there is no error in such case because... you know... there is no error!
					break;

				case 'user':
					throw ResponseErrorException::invalidUserInput($resultNode);
					break;

				case 'forbidden':
					throw ResponseErrorException::unauthorizedAccess();
					break;

				case 'params':
					throw ResponseErrorException::invalidParameters();
					break;

				default:
					throw ResponseErrorException::unknown($resultNode->getAttribute(Response::TAG_RESULT_ATTRIBUTE_ERROR));
					break;
			}
		}
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

	/**
	 * @param array $array
	 * @return array
	 */
	private function convertArrayToFormData(array $array)
	{
		return [
			'form_params' => $array,
		];
	}

}
