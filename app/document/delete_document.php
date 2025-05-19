<?php
include_once '../../configs/connect_db.php';

header('Content-Type: application/json');
session_start();

// Check authentication
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    die(json_encode(['success' => false, 'message' => 'User not logged in']));
}

// Validate input
if (!isset($_POST['doc_id']) || !is_numeric($_POST['doc_id'])) {
    http_response_code(400);
    die(json_encode(['success' => false, 'message' => 'Invalid document ID']));
}

$doc_id = (int)$_POST['doc_id'];
$user_id = (int)$_SESSION['user_id'];

// Start transaction
$conn->begin_transaction();

try {
    // 1. First, verify document exists and get file path
    $stmt = $conn->prepare("SELECT file_path FROM documents WHERE id = ?");
    $stmt->bind_param("i", $doc_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $document = $result->fetch_assoc();
    $stmt->close();

    if (!$document) {
        throw new Exception("Document not found");
    }

    // 4. Delete from documents table
    $delete_stmt = $conn->prepare("DELETE FROM documents WHERE id = ?");
    $delete_stmt->bind_param("i", $doc_id);
    if (!$delete_stmt->execute()) {
        throw new Exception("Failed to delete document: " . $delete_stmt->error);
    }
    
    if ($delete_stmt->affected_rows === 0) {
        throw new Exception("No document was deleted");
    }
    $delete_stmt->close();

    // 5. Delete physical file
    if (file_exists($document['file_path'])) {
        if (!unlink($document['file_path'])) {
            throw new Exception("Failed to delete physical file");
        }
    }

    // Commit transaction
    $conn->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Document deleted successfully'
    ]);

} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}

$conn->close();
?>