<?php
include_once '../../connect_db.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$id = isset($data['id']) ? (int)$data['id'] : null;
$name = trim($data['name'] ?? '');
$description = trim($data['description'] ?? '');

if (!$id || $name === '') {
    echo json_encode(['success' => false, 'message' => 'Category name is required.']);
    exit;
}

try {
    // Check for duplicate name
    $check = $conn->prepare("SELECT id FROM document_categories WHERE name = ? AND id != ?");
    $check->bind_param("si", $name, $id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'Category name already exists.']);
        exit;
    }

    // Update
    $stmt = $conn->prepare("UPDATE document_categories SET name = ?, description = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $description, $id);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}