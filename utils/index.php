<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Content-Type: application/json");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once '../config/database.php';
require_once '../utils/response.php';

$db = (new Database())->connect();

// Load route and method
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Clean and split URI parts
$uriParts = array_values(array_filter(explode('/', $requestUri)));
$apiIndex = array_search('api', $uriParts);
$route = implode('/', array_slice($uriParts, $apiIndex + 1));

// Include API routes
$routes = [
    'auth/signup'             => ['POST', '../api/auth/signup.php'],
    'auth/login'              => ['POST', '../api/auth/login.php'],
    'auth/logout'             => ['POST', '../api/auth/logout.php'],
    'auth/profile'            => ['GET',  '../api/auth/profile.php'],
    'auth/profile/update'     => ['PUT',  '../api/auth/profile_update.php'],
    'auth/otp/send'           => ['POST', '../api/auth/otp_send.php'],
    'auth/otp/verify'         => ['POST', '../api/auth/otp_verify.php'],

    'services'                => ['GET',  '../api/services/list.php'],
    'services/:id'            => ['GET',  '../api/services/detail.php'],

    'categories'              => ['GET',  '../api/categories/list.php'],
    'categories/:id'          => ['GET',  '../api/categories/detail.php'],

    'bookings/create'         => ['POST', '../api/bookings/create.php'],
    'bookings'                => ['GET',  '../api/bookings/list.php'],
    'bookings/:id'            => ['GET',  '../api/bookings/status.php'],
    'bookings/:id/cancel'     => ['PUT',  '../api/bookings/cancel.php'],

    'provider/bookings/assigned'      => ['GET',  '../api/provider/bookings_assigned.php'],
    'provider/bookings/:id/accept'    => ['POST', '../api/provider/accept_booking.php'],
    'provider/bookings/:id/complete'  => ['POST', '../api/provider/complete_booking.php'],
    'provider/earnings'               => ['GET',  '../api/provider/earnings.php'],

    'payment/initialize'      => ['POST', '../api/payment/initialize.php'],
    'payment/verify'          => ['POST', '../api/payment/verify.php'],
    'payment/history'         => ['GET',  '../api/payment/history.php'],

    'reviews/create'          => ['POST', '../api/reviews/create.php'],
    'reviews/service/:id'     => ['GET',  '../api/reviews/service.php'],
    'reviews/provider/:id'    => ['GET',  '../api/reviews/provider.php'],

    'address/add'             => ['POST', '../api/address/add.php'],
    'address'                 => ['GET',  '../api/address/list.php'],
    'address/:id'             => ['DELETE', '../api/address/delete.php']
];

// Try to match static and parameterized routes
$found = false;
foreach ($routes as $pattern => [$method, $script]) {
    $routePattern = preg_replace('/:\w+/', '(\w+)', str_replace('/', '\/', $pattern));
    if (preg_match("/^$routePattern$/", $route, $matches) && $requestMethod === $method) {
        $_GET['params'] = array_slice($matches, 1); // capture route params
        require $script;
        $found = true;
        break;
    }
}

if (!$found) {
    sendError("API route not found", 404);
}
