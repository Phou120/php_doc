<?php
include_once __DIR__ . '/../../connect_db.php';

header('Content-Type: application/json');
session_start();

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['success' => false, 'message' => 'Method not allowed']));
}

// Get JSON input
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validate input
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    die(json_encode(['success' => false, 'message' => 'Invalid JSON']));
}

if (!isset($data['document_id']) || !is_numeric($data['document_id'])) {
    http_response_code(400);
    die(json_encode(['success' => false, 'message' => 'Invalid document ID']));
}

$document_id = (int)$data['document_id'];

try {
    // Verify document exists and get details
    $stmt = $conn->prepare("SELECT id, title, file_path, file_type FROM documents WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Database error: " . $conn->error);
    }
    
    $stmt->bind_param("i", $document_id);
    if (!$stmt->execute()) {
        throw new Exception("Database error: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    $document = $result->fetch_assoc();
    $stmt->close();

    if (!$document) {
        http_response_code(404);
        die(json_encode(['success' => false, 'message' => 'Document not found']));
    }

    // Check if user has permission to view (add your own permission logic)
    $canView = true; // Replace with your permission check
    
    if (!$canView) {
        http_response_code(403);
        die(json_encode(['success' => false, 'message' => 'Access denied']));
    }

    // Log the view action
    if (isset($_SESSION['user_id'])) {
        $log_stmt = $conn->prepare("INSERT INTO document_access_logs (document_id, user_id, action) VALUES (?, ?, 'view')");
        $log_stmt->bind_param("ii", $document_id, $_SESSION['user_id']);
        $log_stmt->execute();
        $log_stmt->close();
    }

    // Return document data
    echo json_encode([
        'success' => true,
        'document' => [
            'id' => $document['id'],
            'title' => $document['title'],
            'file_path' => $document['file_path'],
            'file_type' => $document['file_type'],
            'view_url' => "http://localhost/documentation_system/" . $document['file_path']
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred',
        'error' => $e->getMessage()
    ]);
}

$conn->close();
?>