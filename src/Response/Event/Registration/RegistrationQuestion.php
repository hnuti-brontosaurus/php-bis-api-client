<?php

namespace HnutiBrontosaurus\BisApiClient\Response\Event\Registration;


final class RegistrationQuestion
{

	/** @var string */
	private $question;


	/**
	 * @param string $question
	 */
	private function __construct($question)
	{
		$this->question = $question;
	}

	/**
	 * @param string $question
	 * @return self
	 */
	public static function from($question)
	{
		return new self($question);
	}


	/**
	 * @return string
	 */
	public function toString()
	{
		return $this->__toString();
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->question;
	}

}
