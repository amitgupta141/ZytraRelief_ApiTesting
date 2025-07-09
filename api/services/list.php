<?php
require_once __DIR__. '/../../config/database.php';
require_once __DIR__. '/../../utils/response.php';

header('Content-Type: application/json'); 

try{
    $pdo = (new Database())->connect();
    $stmt = $pdo->query("select * from services");
    if ($stmt->rowCount() === 0) {
        sendError("Booking not found", 404);
    }
    $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
    sendResponse($services, "Services fetched successfully");

}catch(PDOException $e){
    sendError("Database error: " . $e->getMessage(), 500);
}

?>

