<?php
session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../utils/response.php';

header('Content-Type: application/json');

// Only allow PUT method
if ($_SERVER["REQUEST_METHOD"] !== "PUT") {
    sendError("Invalid request method", 405);
}

// Must be logged in
if (!isset($_SESSION['userID']) || !isset($_SESSION['userType'])) {
    sendError("Unauthorized. Please log in.", 401);
}

$userID = $_SESSION['userID'];
$userType = $_SESSION['userType'];

// Get JSON body
$input = json_decode(file_get_contents("php://input"), true);

if (!$input || !isset($input['name']) || !isset($input['email'])) {
    sendError("Missing required fields: name and email", 422);
}

$name = trim($input['name']);
$email = trim($input['email']);

try {
    $pdo = (new Database())->connect();

    if ($userType === 'provider') {
        $stmt = $pdo->prepare("update providers SET name = :name, email = :email where provider_id = :id");
    } else {
        // $stmt = $pdo->prepare("update users SET userName = :name, userEmail = :email WHERE userID = :id");
    }

    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'id' => $userID
    ]);

    sendResponse([
        'id' => $userID,
        'name' => $name,
        'email' => $email
    ], "Profile updated successfully");

} catch (PDOException $e) {
    sendError("Database error: " . $e->getMessage(), 500);
}
