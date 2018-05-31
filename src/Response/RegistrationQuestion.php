<?php

namespace HnutiBrontosaurus\BisApiClient\Response;


final class RegistrationQuestion
{

	/** @var string */
	private $question;


	/**
	 * @param string $question
	 */
	public function __construct($question)
	{
		$this->question = $question;
	}


	/**
	 * @return string
	 */
	public function getQuestion()
	{
		return $this->question;
	}

}
