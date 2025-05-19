<?php
// user_profile.php
include_once '../../../configs/connect_db.php';

// Initialize variables
$user = null;
$error = null;
$success = null;

// Check if user is logged in via localStorage (client-side) and via session (server-side)
session_start();
if (!isset($_SESSION['user_id'])) {
    // This will run when the page first loads or when form is submitted
    if (isset($_POST['user_id'])) {
        // If user_id comes from the form, store it in session
        $_SESSION['user_id'] = intval($_POST['user_id']);
    }
}

// Get user ID from session if available
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

// Handle form submission to update user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['user_id']) ? intval($_POST['user_id']) : $user_id;

    // Handle update
    if (isset($_POST['update_user'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);

        if ($id && $name && $email) {
            // Check if the email already exists for any other user (excluding the current user)
            $checkStmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $checkStmt->bind_param("si", $email, $id);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows > 0) {
                $error = "This email is already in use by another user.";
            } else {
                // Email is unique, proceed with update
                $stmt = $conn->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
                $stmt->bind_param("ssi", $name, $email, $id);
                if ($stmt->execute()) {
                    $success = "Profile updated successfully.";
                } else {
                    $error = "Failed to update user.";
                }
            }
        } else {
            $error = "Invalid input.";
        }
    }
}


// Load user data
if ($user_id) {
    $stmt = $conn->prepare("SELECT id, name, email, created_at FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if (!$user) {
        $error = "User not found.";
    }
}
?>