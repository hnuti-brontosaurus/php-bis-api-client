<?php declare(strict_types = 1);

use HnutiBrontosaurus\BisClient\BisClient;


/** @var BisClient $client */
$client = require_once __DIR__ . '/bootstrap.php';
$idInput = $_GET['id'] ?? '';
$idValue = is_string($idInput) ? $idInput : '';
?>

<h2>Administration unit</h2>
<form method="get">
	ID: <input type="text" name="id" value="<?php echo htmlspecialchars($idValue, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
	<input type="submit" value="Go">
</form>

<?php

$id = filter_var($idValue, FILTER_VALIDATE_INT);
if ($idValue === '' || $id === false) {
	exit;
}

$units = $client->getAdministrationUnits();
foreach ($units as $unit) {
	if ($unit->id === $id) {
		expanded_dump($unit);
		exit;
	}
}

echo 'not found';
