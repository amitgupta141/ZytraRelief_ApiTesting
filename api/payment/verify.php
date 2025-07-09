<?php
require_once __DIR__. '/../../config/database.php';
require_once __DIR__. '/../../utils/response.php';
require_once __DIR__. '/../../utils/auth_middleware.php';

header('Content-Type: application/json'); 

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    sendError("Invalid JSON body", 400);
}

$required = ['booking_id','amount','payment_method','payment_date','status'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        sendError("Missing or empty field: $field", 422);
    }
}

// $payment_id = $data['payment_id'] ?? '';
$booking_id = $data['booking_id'] ?? '';
// $provider_id = $data['provider_id'] ?? 1; // fake for now
$amount = $data['amount'] ?? 0;
$payment_method = $data['payment_method'] ?? '';
$payment_date = $data['payment_date'] ?? date("Y-m-d");
$status = $data['status'] ?? 'pending';
  
try{
    $pdo = (new Database())->connect();
    $stmt = $pdo->prepare("insert into payments (booking_id, amount, payment_method, payment_date, status) VALUES (:booking_id, :amount, :payment_method, :payment_date, :status)");
    $stmt->execute([
        'booking_id' => $booking_id,
        'amount' => $amount,
        'payment_method' => $payment_method,
        'payment_date' => $payment_date,
        'status' => $status
    ]); // static amount


     sendResponse([], "Payment verified");
}catch(PDOException $e){
    sendError("Database error: " . $e->getMessage(), 500);
}

?>