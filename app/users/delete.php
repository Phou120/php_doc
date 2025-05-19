<?php
include_once '../../configs/connect_db.php';

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data (JSON)
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id'])) {
        $id = $data['id'];

        // Perform the deletion query
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'User deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete user']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No user ID provided']);
    }
}
?>