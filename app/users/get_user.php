<?php
// Enable error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
include_once '../../configs/connect_db.php';

// Check if user_id is passed in the URL
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Query to get user data by user_id
    $sql = "SELECT id, name, email, created_at FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);  // 'i' means integer type
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a user is found
    if ($result->num_rows > 0) {
        // Fetch the user data
        $user = $result->fetch_assoc();

        // Send the user data as JSON response
        echo json_encode(['success' => true, 'user' => $user]);
    } else {
        // User not found
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }
} else {
    // If no user_id is provided
    echo json_encode(['success' => false, 'message' => 'User ID not provided']);
}

?>