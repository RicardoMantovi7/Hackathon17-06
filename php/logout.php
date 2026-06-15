<?php
require_once __DIR__ . '/classes/ApiClient.php';

$api = new ApiClient();
$api->logout();

header('Location: index.php');
exit;