<?php
require_once __DIR__. '/../../config/database.php';
require_once __DIR__. '/../../utils/response.php';

header('Content-Type: application/json');  // 👈 Optional, but helpful

$serviceID = $_GET['id'] ?? null;
error_log('ID',$serviceID);

if (!$serviceID) {
    sendError("Service ID not provided", 400);
}

try{
    $pdo = (new Database())->connect();

    $stmt = $pdo->prepare("select * from services where service_id = :id");
    $stmt->execute(['id' => $serviceID]);

    if ($stmt->rowCount() === 0) {
        sendError("Service not found", 404);
    }

    $service = $stmt->fetch(PDO::FETCH_ASSOC);
    sendResponse(['services' => $service]);
}catch(PDOException $e){
    sendError("Database error: " . $e->getMessage(), 500);
}

?>