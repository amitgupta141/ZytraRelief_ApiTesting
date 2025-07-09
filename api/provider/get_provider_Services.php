<?php
session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../utils/response.php';

header('Content-Type: application/json');

// Allow only GET
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    sendError("Invalid request method", 405);
}

// Check if provider is logged in
if (!isset($_SESSION['userID']) || $_SESSION['userType'] !== 'provider') {
    sendError("Unauthorized access. Only providers can access this endpoint.", 401);
}

$provider_id = $_SESSION['userID'];

try {
    $pdo = (new Database())->connect();

    $sql = "
        select 
            ps.id AS provider_service_id,
            s.service_id,
            s.service_name,
            s.service_description,
            ps.price
        from provider_services ps
        join services s ON ps.service_id = s.service_id
        where ps.provider_id = :provider_id
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['provider_id' => $provider_id]);

    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);

    sendResponse($services, "Provider services fetched successfully");
} catch (PDOException $e) {
    sendError("Database error: " . $e->getMessage(), 500);
}
