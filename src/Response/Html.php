<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Response;

use Stringable;


/**
 * Purpose of this class is to recognize HTML from string easily
 */
final readonly class Html implements Stringable
{

	private function __construct(
		private string $html,
	) {}


	/**
	 * @param string $html Be sure to pass only trusted HTML!
	 */
	public static function of(string $html): self
	{
		return new self($html);
	}


	public function __toString(): string
	{
		return $this->html;
	}

}
