<?php

namespace HnutiBrontosaurus\BisApiClient\Response;

use HnutiBrontosaurus\BisApiClient\BisClientException;


abstract class ResponseErrorException extends BisClientException
{}

final class InvalidParametersException extends ResponseErrorException
{}

final class InvalidUserInputException extends ResponseErrorException
{

	/**
	 * @param \DOMElement $element
	 */
	public function __construct(\DOMElement $element)
	{
		parent::__construct($element->nodeValue);
	}

}

final class UnauthorizedAccessException extends ResponseErrorException
{

	public function __construct()
	{
		parent::__construct('You are not authorized to make such request with given credentials. Or you have simply wrong credentials. :-)');
	}

}

final class UnknownErrorException extends ResponseErrorException
{

	/**
	 * @param string $unknownErrorTypeKey
	 */
	public function __construct($unknownErrorTypeKey)
	{
		parent::__construct('Unknown error. Error type returned from BIS: ' . $unknownErrorTypeKey);
	}

}
