<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient;


/**
 * Exception caused by bad usage by developer (preventable)
 * e.g. called method in a wrong moment
 * Generic catch-all exception for all subtypes.
 */
class UsageException extends \LogicException {}

/**
 * Exception caused by unpredictable circumstances on server (not preventable)
 * e.g. file does not exist, external system not accessible etc.
 * Generic catch-all exception for all subtypes.
 */
class RuntimeException extends \RuntimeException {}


final class UnableToProcessRequest extends RuntimeException
{
	public static function withPrevious(\Throwable $previous): self
	{
		return new self($previous->getMessage(), 0, $previous);
	}
}

final class UnableToAuthorize extends RuntimeException
{
	public static function withPrevious(\Throwable $previous): self
	{
		return new self("You are not authorized to make such request with given secrets.\nCheck that you passed correct secrets or that you have access to the resource you requested.", 0, $previous);
	}
}

final class NotFound extends RuntimeException
{
	public static function withPrevious(\Throwable $previous): self
	{
		return new self('The target you requested was not found. Check again that you\'ve typed correct URL or that the resource exists.', 0, $previous);
	}
}
final class ConnectionToBisFailed extends RuntimeException
{
	public static function withPrevious(\Throwable $previous): self
	{
		return new self($previous->getMessage(), 0, $previous);
	}
}
