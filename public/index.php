<?php
error_log("✅ Entered index.php");
require_once __DIR__ . '/../router.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

error_log("📢 METHOD: $method");
error_log("📢 URI: $uri"); 

// Optional: Debug
error_log("METHOD: $method, URI: $uri");

route($method, $uri);
?>
