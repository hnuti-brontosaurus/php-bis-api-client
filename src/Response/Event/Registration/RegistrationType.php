<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisApiClient\Response\Event\Registration;

use HnutiBrontosaurus\BisApiClient\BadUsageException;
use HnutiBrontosaurus\BisApiClient\Response\RegistrationTypeException;


final class RegistrationType
{

	const TYPE_VIA_BRONTOWEB = 1;
	const TYPE_VIA_EMAIL = 2;
	const TYPE_VIA_CUSTOM_WEBPAGE = 3;
	const TYPE_NONE = 4;
	const TYPE_DISABLED = 5;


	private bool $hasValidData;


	/**
	 * @param RegistrationQuestion[] $questions
	 */
	private function __construct(
		private int $type, // one of above constant values
		private array $questions, // in case of registering via Brontoweb
		private ?string $email, // in case of registering via e-mail
		private ?string $url, // in case of registering via custom webpage
	) {
		$this->hasValidData = match (true) {
			$type === self::TYPE_VIA_EMAIL && $email === null,
			$type === self::TYPE_VIA_CUSTOM_WEBPAGE && $url === null,
				=> false,
			default => true
		};
	}

	/**
	 * @param RegistrationQuestion[] $questions
	 */
	public static function from(
		int $type,
		array $questions,
		?string $email,
		?string $url,
	): self
	{
		if ( ! \in_array($type, [
			self::TYPE_VIA_BRONTOWEB,
			self::TYPE_VIA_EMAIL,
			self::TYPE_VIA_CUSTOM_WEBPAGE,
			self::TYPE_NONE,
		], true)) {
			$type = self::TYPE_DISABLED; // silent fallback
		}

		return new self($type, $questions, $email, $url);
	}


	// registration via Brontoweb

	public function isOfTypeBrontoWeb(): bool
	{
		return $this->type === self::TYPE_VIA_BRONTOWEB;
	}


	public function areAnyQuestions(): bool
	{
		return \count($this->questions) > 0;
	}

	/**
	 * @return RegistrationQuestion[]
	 */
	public function getQuestions(): array
	{
		return $this->questions;
	}


	// registration via e-mail

	public function isOfTypeEmail(): bool
	{
		return $this->type === self::TYPE_VIA_EMAIL;
	}

	/**
	 * @throws RegistrationTypeException
	 * @throws BadUsageException
	 */
	public function getEmail(): ?string
	{
		if ( ! $this->hasValidData()) {
			throw RegistrationTypeException::missingAdditionalData('email', $this->type);
		}

		if ( ! $this->isOfTypeEmail()) {
			throw new BadUsageException('This method can not be called when the registration is not of `via e-mail` type.');
		}

		return $this->email;
	}


	// registration via custom webpage

	public function isOfTypeCustomWebpage(): bool
	{
		return $this->type === self::TYPE_VIA_CUSTOM_WEBPAGE;
	}

	/**
	 * @throws RegistrationTypeException
	 * @throws BadUsageException
	 */
	public function getUrl(): ?string
	{
		if ( ! $this->hasValidData()) {
			throw RegistrationTypeException::missingAdditionalData('url', $this->type);
		}

		if ( ! $this->isOfTypeCustomWebpage()) {
			throw new BadUsageException('This method can not be called when the registration is not of `via custom webpage` type.');
		}

		return $this->url;
	}


	// no registration needed

	public function isOfTypeNone(): bool
	{
		return $this->type === self::TYPE_NONE;
	}


	// registration disabled

	public function isOfTypeDisabled(): bool
	{
		return $this->type === self::TYPE_DISABLED;
	}


	public function hasValidData(): bool
	{
		return $this->hasValidData;
	}

}
