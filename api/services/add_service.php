<?php

error_log("✅ add_service.php loaded");


require_once __DIR__. '/../../config/database.php';
require_once __DIR__. '/../../utils/response.php';

header('Content-Type: application/json');  // 👈 Optional, but helpful

// Parse input
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    sendError("Invalid JSON body", 400);
}

$required = ['name', 'category', 'description', 'price', 'duration','image_url'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        sendError("Missing or empty field: $field", 422);
    }
}

try {
    $pdo = (new Database())->connect();

    $stmt = $pdo->prepare("
        INSERT INTO services 
            (name, category, description, price, duration, image_url) 
        VALUES 
            (:name, :category, :description, :price, :duration, :image_url)
    ");

    $stmt->execute([
        'name' => $data['name'],
        'category' => $data['category'],
        'description' => $data['description'],
        'price' => $data['price'],
        'duration' => $data['duration'],
        'image_url' => $data['image_url']
    ]);

    sendResponse([], "Service created successfully");

} catch (PDOException $e) {
    sendError("Database error: " . $e->getMessage(), 500);
}

?>
