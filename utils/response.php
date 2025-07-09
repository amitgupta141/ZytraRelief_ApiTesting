<?php
function sendResponse($data = [], $message = "Success", $code = 200) {
    http_response_code($code);
    echo json_encode([
        'status' => 'success',
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

function sendError($message = "Error", $code = 500) {
    http_response_code($code);
    echo json_encode([
        'status' => 'error',
        'message' => $message,
        'data' => []
    ]);
    exit;
}
?>
