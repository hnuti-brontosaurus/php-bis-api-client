<?php

namespace HnutiBrontosaurus\BisApiClient\Response\Event\Registration;

use HnutiBrontosaurus\BisApiClient\BadUsageException;
use HnutiBrontosaurus\BisApiClient\Response\RegistrationTypeException;


final class RegistrationType
{

	const TYPE_NONE = 0;
	const TYPE_VIA_BRONTOWEB = 1;
	const TYPE_VIA_EMAIL = 2;
	const TYPE_VIA_CUSTOM_WEBPAGE = 3;
	const TYPE_DISABLED = 5;


	/** @var int One of above constant values. */
	private $type;

	/** @var RegistrationQuestion[] In case of registering via Brontoweb. */
	private $questions = [];

	/** @var string|null In case of registering via e-mail. */
	private $email;

	/** @var string|null In case of registering via custom webpage. */
	private $url;

	/** @var bool */
	private $hasValidData = true;


	/**
	 * @param int $type
	 * @param array|null $questions
	 * @param string|null $email
	 * @param string|null $url
	 */
	private function __construct($type, array $questions = null, $email = null, $url = null)
	{
		if ( ! \in_array($type, [
			self::TYPE_NONE,
			self::TYPE_VIA_BRONTOWEB,
			self::TYPE_VIA_EMAIL,
			self::TYPE_VIA_CUSTOM_WEBPAGE,
		], true)) {
			$type = self::TYPE_DISABLED; // silent fallback
		}

		$this->type = $type;

		if ($type === self::TYPE_VIA_BRONTOWEB && $questions !== null && \count($questions) > 0) {
			$this->questions = \array_map(function ($question) {
				return RegistrationQuestion::from($question);
			}, $questions);
		}

		if ($type === self::TYPE_VIA_EMAIL) {
			if ($email === null) {
				$this->hasValidData = false;
			}

			$this->email = $email;
		}

		if ($type === self::TYPE_VIA_CUSTOM_WEBPAGE) {
			if ($url === null) {
				$this->hasValidData = false;
			}

			$this->url = $url;
		}
	}

	/**
	 * @param int $type
	 * @param array|null $questions
	 * @param string|null $email
	 * @param string|null $url
	 * @return self
	 */
	public static function from($type, array $questions = null, $email = null, $url = null)
	{
		return new self($type, $questions, $email, $url);
	}


	/**
	 * @return bool
	 */
	public function isOfTypeNone()
	{
		return $this->type === self::TYPE_NONE;
	}


	// registration via Brontoweb

	/**
	 * @return bool
	 */
	public function isOfTypeBrontoWeb()
	{
		return $this->type === self::TYPE_VIA_BRONTOWEB;
	}

	/**
	 * @return bool
	 */
	public function areAnyQuestions()
	{
		return \count($this->questions) > 0;
	}

	/**
	 * @return RegistrationQuestion[]
	 */
	public function getQuestions()
	{
		return $this->questions;
	}


	// registration via e-mail

	/**
	 * @return bool
	 */
	public function isOfTypeEmail()
	{
		return $this->type === self::TYPE_VIA_EMAIL;
	}

	/**
	 * @return string|null
	 * @throws RegistrationTypeException
	 * @throws BadUsageException
	 */
	public function getEmail()
	{
		if ( ! $this->hasValidData()) {
			throw RegistrationTypeException::missingAdditionalData('email', $this->type);
		}

		if ( ! $this->isOfTypeEmail()) {
			throw new BadUsageException('This method can not be called when the registration is not of `via e-mail` type.');
		}

		return $this->email;
	}


	// registration custom webpage

	/**
	 * @return bool
	 */
	public function isOfTypeCustomWebpage()
	{
		return $this->type === self::TYPE_VIA_CUSTOM_WEBPAGE;
	}

	/**
	 * @return string|null
	 * @throws RegistrationTypeException
	 * @throws BadUsageException
	 */
	public function getUrl()
	{
		if ( ! $this->hasValidData()) {
			throw RegistrationTypeException::missingAdditionalData('url', $this->type);
		}

		if ( ! $this->isOfTypeCustomWebpage()) {
			throw new BadUsageException('This method can not be called when the registration is not of `via custom webpage` type.');
		}

		return $this->url;
	}


	// registration disabled

	public function isOfTypeDisabled()
	{
		return $this->type === self::TYPE_DISABLED;
	}


	public function hasValidData()
	{
		return $this->hasValidData;
	}

}
