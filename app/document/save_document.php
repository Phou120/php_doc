<?php
// Database connection
include_once '../../configs/connect_db.php';

// Set response header
header('Content-Type: application/json');

// Initialize response array
$response = [
    'success' => false,
    'message' => '',
    'file_path' => ''
];

try {
    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Check if all required fields are present
    if (!isset($_POST['title'])) {
        throw new Exception('Document title is required');
    }

    if (!isset($_POST['category_id'])) {
        throw new Exception('Category is required');
    }

    if (!isset($_POST['user_id'])) {
        throw new Exception('User ID is required');
    }

    if (!isset($_FILES['file'])) {
        throw new Exception('No file was uploaded');
    }

    // Get form data
    $title = trim($_POST['title']);
    $category_id = intval($_POST['category_id']);
    $user_id = intval($_POST['user_id']); // Get user_id from form submission
    $file = $_FILES['file'];

    // Validate title
    if (empty($title)) {
        throw new Exception('Document title cannot be empty');
    }

    // Validate category
    if ($category_id <= 0) {
        throw new Exception('Invalid category selected');
    }

    // Validate user_id
    if ($user_id <= 0) {
        throw new Exception('Invalid user ID');
    }

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('File upload error: ' . $file['error']);
    }

    // Validate file size (max 10MB)
    $maxFileSize = 10 * 1024 * 1024; // 10MB
    if ($file['size'] > $maxFileSize) {
        throw new Exception('File size exceeds maximum limit of 10MB');
    }

    // Get file info
    $file_name = basename($file['name']);
    $file_tmp = $file['tmp_name'];
    $file_type = $file['type'];
    $file_size = $file['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Allowed file types
    $allowed_extensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png', 'gif', 'txt', 'csv', 'zip', 'rar'];

    // Validate file extension
    if (!in_array($file_ext, $allowed_extensions)) {
        throw new Exception('File type not allowed. Allowed types: ' . implode(', ', $allowed_extensions));
    }

    // Create upload directory if it doesn't exist
    $upload_dir = '../../uploads/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Generate unique filename to prevent overwrites
    $unique_name = uniqid() . '_' . time() . '.' . $file_ext;
    $file_path = $upload_dir . $unique_name;

    // Move uploaded file to permanent location
    if (!move_uploaded_file($file_tmp, $file_path)) {
        throw new Exception('Failed to move uploaded file');
    }

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO documents (user_id, title, file_name, file_path, file_type, file_size, category_id, uploaded_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    // Correct parameter types: i (int), s (string), s, s, s, i (int), i (int)
    $stmt->bind_param("issssii", $user_id, $title, $file_name, $file_path, $file_type, $file_size, $category_id);

    // Execute the statement
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Document uploaded successfully';
        $response['file_path'] = $file_path;
    } else {
        // If database insert fails, delete the uploaded file
        unlink($file_path);
        throw new Exception('Failed to save document to database: ' . $stmt->error);
    }

    $stmt->close();
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
} finally {
    // Close database connection
    $conn->close();

    // Return JSON response
    echo json_encode($response);
}
?>