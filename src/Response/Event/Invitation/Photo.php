<?php

namespace HnutiBrontosaurus\BisApiClient\Response\Event\Invitation;


final class Photo
{

	/** @var string */
	private $path;


	/**
	 * @param $path
	 */
	private function __construct($path)
	{
		$this->path = $path;
	}


	/**
	 * @param $path
	 * @return self
	 */
	public static function from($path)
	{
		return new self($path);
	}


	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}

}
