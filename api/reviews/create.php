<?php
require_once __DIR__. '/../../config/database.php';
require_once __DIR__. '/../../utils/response.php';
require_once __DIR__. '/../../utils/auth_middleware.php';

header('Content-Type: application/json');  

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    sendError("Invalid JSON body", 400);
}

$required = ['user_id','provider_id','rating','comment'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        sendError("Missing or empty field: $field", 422);
    }
}


// $review_id = $data['review_id'] ?? null;
$user_id = $data['user_id'] ?? null;
$provider_id = $data['provider_id'] ?? null;
$rating = $data['rating'] ?? null;
$comment = $data['comment'] ?? '';


if (!$provider_id || !$rating) sendError("Rating and service ID required", 400);

try{
    $pdo = (new Database())->connect();
    $stmt = $pdo->prepare("insert into reviews (user_id, provider_id, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user_id, $provider_id, $rating, $comment]);
    
    sendResponse([], "Review submitted");
}
catch(PDOException $e){
    sendError("Database error: " . $e->getMessage(), 500);
}
?>