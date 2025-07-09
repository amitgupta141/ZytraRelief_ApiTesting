<?php
require_once __DIR__. '/../../config/database.php';
require_once __DIR__. '/../../utils/response.php';

header('Content-Type: application/json');  // 👈 Optional, but helpful


$id = $_GET['id'] ?? null;
$data = json_decode(file_get_contents("php://input"), true);

if (!$id) sendError("Service ID required", 400);

try{
    $pdo = (new Database())->connect();
    // Get current booking
    $delete = $pdo->prepare("delete from services where service_id = :id");
    $delete->execute(['id' => $id]);

    sendResponse([], "Service deleted successfully");

} catch (PDOException $e) {
    sendError("Database error: " . $e->getMessage(), 500);
}

?>