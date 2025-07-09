<?php
require_once __DIR__. '/../../config/database.php';
require_once __DIR__. '/../../utils/response.php';

header('Content-Type: application/json');


$provider_id = $_GET['id'] ?? null;

if (!$provider_id) {
    sendError("Provider ID not provided", 400);
}

try{
    $pdo = (new Database())->connect();
    $stmt = $pdo->prepare("select * from reviews where provider_id = :id");
    $stmt->execute(['id' => $provider_id]);
    if ($stmt->rowCount() === 0) {
        sendError("Provider not found", 404);
    }
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    sendResponse(['reviews' => $reviews], "Provider reviews");
}catch(PDOException $e){
    sendError("Database error: " . $e->getMessage(), 500);
}

?>


