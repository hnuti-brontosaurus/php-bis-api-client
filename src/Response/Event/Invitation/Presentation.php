<?php

namespace HnutiBrontosaurus\BisApiClient\Response\Event\Invitation;


final class Presentation
{

	/** @var string|null */
	private $text;

	/** @var bool */
	private $hasAnyPhotos = false;

	/** @var Photo[] */
	private $photos = [];


	/**
	 * @param string|null $text
	 * @param string[] $photoPaths
	 */
	private function __construct($text, array $photoPaths)
	{
		if ($text !== null) {
			$this->text = $text;
		}

		if (\count($photoPaths) > 0) {
			$this->addPhotos($photoPaths);
		}
	}


	/**
	 * @param string|null $text
	 * @param string[] $photoPaths
	 * @return self
	 */
	public static function from($text = null, array $photoPaths)
	{
		return new self($text, $photoPaths);
	}

	/**
	 * @param string $photoPath
	 * @return self
	 */
	private function addPhoto($photoPath)
	{
		$this->hasAnyPhotos = true;
		$this->photos[] = Photo::from($photoPath);

		return $this;
	}

	/**
	 * @param string[] $photoPaths
	 * @return self
	 */
	private function addPhotos(array $photoPaths)
	{
		foreach ($photoPaths as $photoPath) {
			$this->addPhoto($photoPath);
		}

		return $this;
	}


	/**
	 * @return bool
	 */
	public function hasText()
	{
		return $this->text !== null;
	}

	/**
	 * @return string|null
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
