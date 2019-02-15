<?php

namespace HnutiBrontosaurus\BisApiClient;


class InvalidArgumentException extends \InvalidArgumentException
{}

class ResourceNotFoundException extends \RuntimeException
{}

class BisClientException extends \RuntimeException
{}

final class RegistrationTypeException extends BisClientException
{

	public static function missingAdditionalData($key, $type)
	{
		return new self(\sprintf('Missing additional data `%s` for selected type %d.', $key, $type));
	}

}

final class ResponseErrorException extends BisClientException
{

	/**
	 * @return self
	 */
	public static function invalidParameters()
	{
		return new self('Parameters are invalid.');
	}

	/**
	 * @param \DOMElement $element
	 * @return self
	 */
	public static function invalidUserInput(\DOMElement $element)
	{
		return new self('User input is invalid. Details: ' . $element->nodeValue);
	}

	/**
	 * @return self
	 */
	public static function unauthorizedAccess()
	{
		return new self('You are not authorized to make such request with given credentials. Or you have simply wrong credentials. :-)');
	}

	/**
	 * @param string $unknownErrorTypeKey
	 * @return self
	 */
	public static function unknown($unknownErrorTypeKey)
	{
		return new self('Unknown error. Error type returned from BIS: `' . $unknownErrorTypeKey);
	}

}
