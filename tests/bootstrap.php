<?php declare(strict_types = 1);

use HnutiBrontosaurus\BisClient\BisClientFactory;
use Tracy\Debugger;


require_once __DIR__ . '/../vendor/autoload.php';

Debugger::enable();

// client factory
// wrapped in IIFE not to pollute script with client* variables
return (function () {
	$configuration = require_once __DIR__ . '/config.php';
	['apiUrl' => $apiUrl, 'clientId' => $clientId, 'clientSecret' => $clientSecret] = $configuration;

	return (new BisClientFactory(
		$apiUrl,
		$clientId,
		$clientSecret,
	))->create();
})();
