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
	 * Currently no limitations to what can be in `params`.
	 * @param array $params
	 */
	public function __construct(array $params = [])
	{
		$this->params = $params;
	}


	/**
	 * @return array
	 */
	public function getAll()
	{
		return $this->params;
	}

	/**
	 * @return string
	 */
	public function getQueryString()
	{
		return \http_build_query($this->params);
	}


	/**
	 * @param string $username
	 * @param string $password
	 * @return self
	 */
	public function setCredentials($username, $password)
	{
		$this->params[self::PARAM_USERNAME] = $username;
		$this->params[self::PARAM_PASSWORD] = $password;

		return $this;
	}

}
