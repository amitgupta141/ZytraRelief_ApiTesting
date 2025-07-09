<?php
require_once '../../utils/response.php';

// Example for Razorpay or Stripe integration
$data = json_decode(file_get_contents("php://input"), true);
$amount = $data['amount'] ?? null;

if (!$amount) sendError("Amount required");

$order_id = uniqid('order_');

sendResponse(['order_id' => $order_id, 'amount' => $amount], "Payment initialized");
