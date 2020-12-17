<?php
$db = require __DIR__ . '../../common/config/main-local.php';
$db = $db['components']['db'] ?? [];
// test database! Important not to run tests on production or development databases

$db['dsn'] = 'mysql:host=localhost;dbname=funboot';

return $db;
