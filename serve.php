<?php
// serve.php (used only for PHP dev server routing)
if (php_sapi_name() == 'cli-server') {
    $url = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . '/public' . $url['path'];

    if (is_file($file)) {
        return false; // Serve static files directly
    }
}

require_once __DIR__ . '/public/index.php'; // All API requests go here
?>