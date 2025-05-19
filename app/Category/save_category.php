<?php
header('Content-Type: application/json');
include_once "../../configs/connect_db.php";

// Decode JSON input
$data = json_decode(file_get_contents("php://input"), true);

$name = trim($data['category_name'] ?? '');
$description = trim($data['description'] ?? '');

// Optional validation
if (empty($name)) {
    echo json_encode(['success' => false, 'message' => 'Category name is required.']);
    exit;
}

// Check if category already exists
$checkStmt = $conn->prepare("SELECT id FROM document_categories WHERE name = ?");
$checkStmt->execute([$name]);

if ($checkStmt->fetch()) {
    echo json_encode(['success' => false, 'message' => 'This category already exists.']);
    exit;
}

// Insert into DB
$stmt = $conn->prepare("INSERT INTO document_categories (name, description) VALUES (?, ?)");
if ($stmt->execute([$name, $description])) {
    echo json_encode(['success' => true, 'message' => 'Category added successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to add category.']);
}