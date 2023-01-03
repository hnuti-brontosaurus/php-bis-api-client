<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisClient\Request;


interface ToArray
{

	/** @return array<scalar|\Stringable> */
	public function toArray(): array;

}
