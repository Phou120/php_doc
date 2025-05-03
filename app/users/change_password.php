<?php
include_once "../../connect_db.php";

$userId = $_POST['user_id'] ?? null;
$current = $_POST['current_password'] ?? '';
$new = $_POST['new_password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

if (!$userId || !$current || !$new || !$confirm) {
    echo "All fields are required.";
    exit;
}

if ($new !== $confirm) {
    echo "New password and confirmation do not match.";
    exit;
}

// Fetch user's current password
$stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || !password_verify($current, $user['password'])) {
    echo "Current password is incorrect.";
    exit;
}

$newHashed = password_hash($new, PASSWORD_BCRYPT);
$updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
$updateStmt->bind_param("si", $newHashed, $userId);

if ($updateStmt->execute()) {
    echo "Password updated successfully.";
} else {
    echo "Failed to update password.";
}