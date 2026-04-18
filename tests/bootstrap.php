<?php declare(strict_types = 1);

use HnutiBrontosaurus\BisClient\BisClientFactory;
use Tracy\Debugger;


require_once __DIR__ . '/../vendor/autoload.php';

Debugger::enable(Debugger::Development);
Debugger::$showBar = false;

function expanded_dump($variable) {
	echo Tracy\Dumper::toHtml($variable, [
		Tracy\Dumper::DEPTH => 5,
		Tracy\Dumper::COLLAPSE => false,
	]);
}

// client factory
// wrapped in IIFE not to pollute script with variables from configuration
return (function () {
	$configuration = require_once __DIR__ . '/config.php';
	['apiUrl' => $apiUrl] = $configuration;

	return (new BisClientFactory($apiUrl))
		->create();
})();
