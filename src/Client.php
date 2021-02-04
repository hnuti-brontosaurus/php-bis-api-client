<?php

namespace HnutiBrontosaurus\BisApiClient;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use HnutiBrontosaurus\BisApiClient\Request\Adoption;
use HnutiBrontosaurus\BisApiClient\Request\EventAttendee;
use HnutiBrontosaurus\BisApiClient\Request\EventParameters;
use HnutiBrontosaurus\BisApiClient\Request\OrganizationalUnitParameters;
use HnutiBrontosaurus\BisApiClient\Request\Parameters;
use HnutiBrontosaurus\BisApiClient\Response\Event\Event;
use HnutiBrontosaurus\BisApiClient\Response\InvalidContentTypeException;
use HnutiBrontosaurus\BisApiClient\Response\InvalidParametersException;
use HnutiBrontosaurus\BisApiClient\Response\InvalidUserInputException;
use HnutiBrontosaurus\BisApiClient\Response\InvalidXMLStructureException;
use HnutiBrontosaurus\BisApiClient\Response\OrganizationalUnit\OrganizationalUnit;
use HnutiBrontosaurus\BisApiClient\Response\OrganizationalUnit\UnknownOrganizationUnitTypeException;
use HnutiBrontosaurus\BisApiClient\Response\Response;
use HnutiBrontosaurus\BisApiClient\Response\ResponseErrorException;
use HnutiBrontosaurus\BisApiClient\Response\UnauthorizedAccessException;
use HnutiBrontosaurus\BisApiClient\Response\UnknownErrorException;
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
	 * @throws InvalidArgumentException
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
	 * @throws NotFoundException
	 * @throws TransferErrorException
	 * @throws ResponseErrorException
	 */
	public function getEvent($id, EventParameters $params = null)
	{
		$params = ($params !== null ? $params : new EventParameters());
		$params->setId($id);
		$response = $this->processRequest($params);

		$data = $response->getData();

		if (\count($data) === 0) {
			throw new NotFoundException('No result for event with id `' . $id . '`.');
		}

		return Event::fromResponseData(\reset($data));
	}

	/**
	 * @param EventParameters $params
	 * @return Event[]
	 * @throws NotFoundException
	 * @throws TransferErrorException
	 * @throws ResponseErrorException
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
	 */
	public function addAttendeeToEvent(EventAttendee $eventAttendee)
	{
		$eventAttendee->setCredentials($this->username, $this->password);
		$response = $this->httpClient->send($this->createRequest($eventAttendee));

		$this->checkForResponseContentType($response);

		$domDocument = $this->generateDOM($response);

		$this->checkForResponseErrors($domDocument);
	}


	// organizational units

	/**
	 * @param OrganizationalUnitParameters $params
	 * @return OrganizationalUnit[]
	 * @throws NotFoundException
	 * @throws TransferErrorException
	 * @throws ResponseErrorException
	 */
	public function getOrganizationalUnits(OrganizationalUnitParameters $params = null)
	{
		$response = $this->processRequest($params !== null ? $params : new OrganizationalUnitParameters());

		$organizationalUnits = [];
		foreach ($response->getData() as $organizationalUnit) {
			try {
				$organizationalUnits[] = OrganizationalUnit::fromResponseData($organizationalUnit);

			} catch (UnknownOrganizationUnitTypeException $e) {
				continue; // In case of unknown type - just ignore it.

			}
		}

		return $organizationalUnits;
	}


	// adoption

	/**
	 * @param Adoption $adoption
	 * @throws ResponseErrorException
	 */
	public function saveRequestForAdoption(Adoption $adoption)
	{
		$adoption->setCredentials($this->username, $this->password);

		$response = $this->httpClient->send($this->createRequest($adoption));

		$this->checkForResponseContentType($response);

		$domDocument = $this->generateDOM($response);

		$this->checkForResponseErrors($domDocument);
	}


	/**
	 * @param Parameters $requestParameters
	 * @return Response
	 * @throws NotFoundException
	 * @throws TransferErrorException
	 * @throws ResponseErrorException
	 */
	private function processRequest(Parameters $requestParameters)
	{
		$requestParameters->setCredentials($this->username, $this->password);

		try {
			$response = $this->httpClient->send($this->createRequest($requestParameters));

		} catch (ClientException $e) {
			throw new NotFoundException('Bis client could not find the queried resource.', 0, $e);

		} catch (GuzzleException $e) {
			throw new TransferErrorException('Unable to process request: transfer error.', 0, $e);
		}

		$this->checkForResponseContentType($response);

		$domDocument = $this->generateDOM($response);
		$this->checkForResponseErrors($domDocument);

		return new Response($response, $domDocument);
	}


	/**
	 * @param ResponseInterface $response
	 * @throws InvalidContentTypeException
	 */
	private function checkForResponseContentType(ResponseInterface $response)
	{
		if (\strncmp($response->getHeaderLine('Content-Type'), 'text/xml', \strlen('text/xml')) !== 0) {
			throw new InvalidContentTypeException('Unable to process response: the response Content-Type is invalid or missing.');
		}
	}

	/**
	 * @param ResponseInterface $response
	 * @return \DOMDocument
	 * @throws InvalidXMLStructureException
	 */
	private function generateDOM(ResponseInterface $response)
	{
		try {
			$domDocument = new \DOMDocument();
			$domDocument->loadXML($response->getBody());

		} catch (\Exception $e) {
			throw new InvalidXMLStructureException('Unable to process response: response body contains invalid XML.', 0, $e);
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
		\assert($resultNode instanceof \DOMElement);

		if ($resultNode->hasAttribute(Response::TAG_RESULT_ATTRIBUTE_ERROR)) {
			switch ($resultNode->getAttribute(Response::TAG_RESULT_ATTRIBUTE_ERROR)) {
				case 'success': // In case of POST request with form data, BIS returns `<result error="success" />` for some reason... Let's pretend that there is no error in such case because... you know... there is no error!
					break;

				case 'user':
					throw new InvalidUserInputException($resultNode);
					break;

				case 'forbidden':
					throw new UnauthorizedAccessException();
					break;

				case 'params':
					throw new InvalidParametersException();
					break;

				default:
					throw new UnknownErrorException($resultNode->getAttribute(Response::TAG_RESULT_ATTRIBUTE_ERROR));
					break;
			}
		}
	}

	/**
	 * @return Request
	 */
	private function createRequest(Parameters $parameters)
	{
		return new Request(
			'POST',
			$this->url,
			[
				'Content-Type' => 'application/x-www-form-urlencoded',
			],
			\http_build_query($parameters->getAll())
		);
	}

}
