<?php

namespace HnutiBrontosaurus\BisApiClient\Response\Event;


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
	public function getQuestion()
	{
		return $this->question;
	}

}
