<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;


/**
 * Exception caused by bad usage by developer (preventable)
 * e.g. called method in a wrong moment
 * Not meant to be caught in client code.
 */
class UsageException extends \LogicException {}

/**
 * Exception caused by unpredictable circumstances on server (not preventable)
 * e.g. file does not exist, external system not accessible etc.
 * This is generic exception to catch all possible cases from client.
 * To handle specific cases, catch specific exceptions from below.
 * You can also combine it by catching specific first and then the generic.
 */
class ConnectionToBisFailed extends \RuntimeException {}


final class UnableToProcessRequest extends ConnectionToBisFailed
{
	public static function withPrevious(\Throwable $previous): self
	{
		return new self($previous->getMessage(), 0, $previous);
	}
}

final class NotFound extends ConnectionToBisFailed
{
	public static function withPrevious(\Throwable $previous): self
	{
		return new self('The target you requested was not found. Check again that you\'ve typed correct URL or that the resource exists.', 0, $previous);
	}
}

final class GeneralError extends ConnectionToBisFailed
{
	public static function withPrevious(\Throwable $previous): self
	{
		return new self($previous->getMessage(), 0, $previous);
	}
}
