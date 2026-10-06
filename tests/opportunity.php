<?php declare(strict_types = 1);

use HnutiBrontosaurus\BisClient\BisClient;
use HnutiBrontosaurus\BisClient\NotFound;


/** @var BisClient $client */
$client = require_once __DIR__ . '/bootstrap.php';
$idInput = $_GET['id'] ?? '';
$idValue = is_string($idInput) ? $idInput : '';
?>

<h2>Opportunity</h2>
<form method="get">
	ID: <input type="text" name="id" value="<?php echo htmlspecialchars($idValue, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
	<input type="submit" value="Go">
</form>

<?php

if ($idValue === '') {
	exit;
}

$id = filter_var($idValue, FILTER_VALIDATE_INT);
if ($id === false) {
	exit;
}

try {
	expanded_dump($client->getOpportunity($id));

} catch (NotFound) {
	echo 'not found';
}
