<?php
// Only process PUT requests
if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    // Get the raw PUT data
    $data = json_decode(file_get_contents('php://input'), true);

    // Assuming you have the data in the following format
    $id = $data['id'];
    $name = $data['name'];
    $email = $data['email'];

    // Database connection
    include_once "../../connect_db.php";

    // Prepare your SQL query
    $sql = "UPDATE users SET name = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    // Bind parameters
    $stmt->bind_param('ssi', $name, $email, $id);

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'User updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error updating user']);
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>