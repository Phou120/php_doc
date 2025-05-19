<?php
// log_document_action.php
include_once "../../configs/connect_db.php";

header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    die(json_encode(['success' => false, 'message' => 'Unauthorized']));
}

if (!isset($_POST['doc_id']) || !isset($_POST['action'])) {
    http_response_code(400);
    die(json_encode(['success' => false, 'message' => 'Missing parameters']));
}

$doc_id = (int)$_POST['doc_id'];
$user_id = (int)$_SESSION['user_id'];
$action = $_POST['action'];

$stmt = $conn->prepare("INSERT INTO document_access_logs 
                       (document_id, user_id, action) 
                       VALUES (?, ?, ?)");
$stmt->bind_param("iis", $doc_id, $user_id, $action);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $conn->error]);
}

$stmt->close();
$conn->close();
?>