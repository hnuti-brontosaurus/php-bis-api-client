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
