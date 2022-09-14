<?php declare(strict_types = 1);

use HnutiBrontosaurus\BisClient\BisClient;
use HnutiBrontosaurus\BisClient\NotFound;


/** @var BisClient $client */
$client = require_once __DIR__ . '/bootstrap.php';
?>

<h2>Event</h2>
<form method="get">
	ID: <input type="text" name="id" value="<?php echo $_GET['id'] ?>">
	<input type="submit" value="Go">
</form>

<?php

if (empty($_GET['id'])) {
	exit;
}

try {
	dump($client->getEvent((int) $_GET['id']));

} catch (NotFound) {
	echo 'not found';
}
