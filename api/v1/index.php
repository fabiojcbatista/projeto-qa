<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/routes/routes.php';
header('Content-Type: application/json');
$db = (new Database())->connect();
handleRequest($db);
