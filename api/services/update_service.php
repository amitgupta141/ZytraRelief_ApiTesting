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
    $stmt = $pdo->prepare("select * from services where service_id = :id");
    $stmt->execute(['id' => $id]);
    $service = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$service) sendError("Service not found", 404);
    
    // Merge updates with existing data
    $updated = [
        'service_id'        => $data['service_id']        ?? $service['service_id'],
        'name'    => $data['name']    ?? $service['name'],
        'category'     => $data['category']     ?? $service['category'],
        'description'   => $data['description']   ?? $service['description'],
        'price'        => $data['price']        ?? $service['price'],
        'duration'         => $data['duration']         ?? $service['duration'],
        'image_url' => $data['image_url'] ?? $service['image_url'],
        'id'             => $id
    ];
    
    // Update booking
    $update = $pdo->prepare("update services set
        service_id = :service_id,
        name = :name,
        category = :category,
        description = :description,
        price = :price,
        duration = :duration,
        image_url = :image_url
        where service_id = :id");
    
    $update->execute($updated);
    
    sendResponse([], "Service updated successfully");

}catch(PDOException $e){

}


?>