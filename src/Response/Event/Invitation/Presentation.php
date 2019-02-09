<?php

namespace HnutiBrontosaurus\BisApiClient\Response\Event\Invitation;


final class Presentation
{

	/** @var string */
	private $text;

	/** @var bool */
	private $hasAnyPhotos = false;

	/** @var Photo[] */
	private $photos = [];


	/**
	 * @param $text
	 */
	private function __construct($text)
	{
		$this->text = $text;
	}


	/**
	 * @param $text
	 * @return self
	 */
	public static function from($text)
	{
		return new self($text);
	}

	/**
	 * @param string $photoPath
	 * @return self
	 */
	public function addPhoto($photoPath)
	{
		$this->hasAnyPhotos = true;
		$this->photos[] = Photo::from($photoPath);

		return $this;
	}

	/**
	 * @param string[] $photoPaths
	 * @return self
	 */
	public function addPhotos(array $photoPaths)
	{
		foreach ($photoPaths as $photoPath) {
			$this->addPhoto($photoPath);
		}

		return $this;
	}


	/**
	 * @return string
	 */
	public function getText()
	{
		return $this->text;
	}

	/**
	 * @return bool
	 */
	public function hasAnyPhotos()
	{
		return $this->hasAnyPhotos;
	}

	/**
	 * @return Photo[]
	 */
	public function getPhotos()
	{
		return $this->photos;
	}

}
