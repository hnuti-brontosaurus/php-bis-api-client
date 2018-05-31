<?php

/**
 * See https://bis.brontosaurus.cz/myr.html for more information on values.
 */

namespace HnutiBrontosaurus\BisApiClient\Request;


abstract class Parameters
{

	const PARAM_USERNAME = 'user';
	const PARAM_PASSWORD = 'password';

	const PARAM_QUERY = 'query';


	/** @var array */
	protected $params = [];


	/**
	 * Currently no limitations to what can be in params.
	 * @param array $params
	 */
	public function __construct(array $params = NULL)
	{
		$this->params = $params;
	}


	public function getAll()
	{
		return $this->params;
	}

	public function getQueryString()
	{
		return \http_build_query($this->params);
	}


	public function setCredentials($username, $password)
	{
		$this->params[self::PARAM_USERNAME] = $username;
		$this->params[self::PARAM_PASSWORD] = $password;

		return $this;
	}

}
