<?php
session_start();

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../utils/response.php';

header('Content-Type: application/json');

// // Only allow PUT method
// if ($_SERVER["REQUEST_METHOD"] !== "PUT") {
//     sendError("Invalid request method", 405);
// }

// // Must be logged in
// if (!isset($_SESSION['userID']) || !isset($_SESSION['userType'])) {
//     sendError("Unauthorized. Please log in.", 401);
// }

// $userID = $_SESSION['userID'];
// $userType = $_SESSION['userType'];

// // Get JSON body
// $input = json_decode(file_get_contents("php://input"), true);

// if (!$input || !isset($input['name']) || !isset($input['email'])) {
//     sendError("Missing required fields: name and email", 422);
// }

// $name = trim($input['name']);
// $email = trim($input['email']);

// try {
//     $pdo = (new Database())->connect();

//     if ($userType === 'provider') {
//         // $stmt = $pdo->prepare("UPDATE providers SET name = :name, email = :email WHERE provider_id = :id");
//     } else {
//         $stmt = $pdo->prepare("update users SET userName = :name, userEmail = :email WHERE userID = :id");
//     }

//     $stmt->execute([
//         'name' => $name,
//         'email' => $email,
//         'id' => $userID
//     ]);

//     sendResponse([
//         'id' => $userID,
//         'name' => $name,
//         'email' => $email
//     ], "Profile updated successfully");

// } catch (PDOException $e) {
//     sendError("Database error: " . $e->getMessage(), 500);
// }


$data = json_decode(file_get_contents('php://input'), true);

if(!$data || empty($data['userID'])){
    sendError("No fields to update", 400);
}

$id = $data['userID'];

try{

     $pdo = (new Database())->connect();
    
    // Get current booking
    $stmt = $pdo->prepare("select * from users where userID = :id");
    $stmt->execute(['id' => $data['userID']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) sendError("User not found", 404);
    
    // Merge updates with existing data
    $updated = [
        'userName'        => $data['userName']        ?? $user['userName'],
        'userEmail'    => $data['userEmail']    ?? $user['userEmail'],
        'category'     => $data['category']     ?? $user['category'],
        'address'   => $data['address']   ?? $user['address'],
        'userPhone'        => $data['userPhone']        ?? $user['userPhone'],
        'id'             => $id
    ];


    $sql = "update users set
        userName = :userName,
        userEmail = :userEmail,
        category = :category,
        address = :address,
        userPhone = :userPhone
        where userID = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $data['userID']]);
    sendResponse([], "User Profile updated successfully");
}catch(PDOException $e){
    sendError("Database error: " . $e->getMessage(), 500);
}

?>