<?php
require_once __DIR__. '/../../config/database.php';
require_once __DIR__. '/../../utils/response.php';
require_once __DIR__. '/../../utils/auth_middleware.php';

header('Content-Type: application/json'); 

$paymentID = $_GET['id'] ?? null;

if (!$paymentID) {
    sendError("Booking ID not provided", 400);
}

try{
    $pdo = (new Database())->connect();
    $stmt = $pdo->prepare("select * from payments where payment_id = :id");
    $stmt->execute(['id' => $paymentID]);
    if ($stmt->rowCount() === 0) {
        sendError("Booking not found", 404);
    }
    $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
    sendResponse($payments, "Payment history");

}catch(PDOException $e){
     sendError("Database error: " . $e->getMessage(), 500);
}
?>


