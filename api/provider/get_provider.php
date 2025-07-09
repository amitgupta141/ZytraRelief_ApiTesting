<?php
session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../utils/response.php';

header('Content-Type: application/json');

// Allow only GET method
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    sendError("Invalid request method", 405);
}

// Check if user is logged in
if (!isset($_SESSION['userID']) || !isset($_SESSION['userType'])) {
    sendError("Unauthorized. Please log in.", 401);
}

$userID = $_SESSION['userID'];
$userType = $_SESSION['userType'];

try {
    $pdo = (new Database())->connect();

    if ($userType === 'provider') {
        $stmt = $pdo->prepare("select provider_id AS id, name, email from providers where provider_id = :id");
    } else {
        // $stmt = $pdo->prepare("select userID AS id, userName AS name, userEmail AS email from users where userID = :id");
    }

    $stmt->execute(['id' => $userID]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        sendResponse($user, "Profile fetched successfully");
    } else {
        sendError("Provider not found", 404);
    }

} catch (PDOException $e) {
    sendError("Database error: " . $e->getMessage(), 500);
}
