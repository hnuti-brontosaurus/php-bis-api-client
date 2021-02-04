<?php declare(strict_types = 1);

namespace HnutiBrontosaurus\BisApiClient\Request;

use HnutiBrontosaurus\BisApiClient\InvalidArgumentException;


final class OrganizationalUnitParameters extends Parameters
{

	const PARAM_FILTER = 'filter';

	const TYPE_CLUB = 'klub';
	const TYPE_BASE = 'zc';
	const TYPE_REGIONAL = 'rc';


	public function __construct()
	{
		parent::__construct([
			self::PARAM_QUERY => 'zc'
		]);
	}


	/**
	 * @param string $type
	 * @return self
	 * @throws InvalidArgumentException
	 */
	public function setType($type)
	{
		if (!\in_array($type, [
			self::TYPE_CLUB,
			self::TYPE_BASE,
			self::TYPE_REGIONAL,
		], true)) {
			throw new InvalidArgumentException('Type `' . $type . '` is not of valid types.');
		}

		$this->params[self::PARAM_FILTER] = $type;

		return $this;
	}

}
