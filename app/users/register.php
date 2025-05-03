<?php
include_once '../../connect_db.php';
session_start();

// Function: Create User
function createUser($conn, $name, $email, $password) {
    // Check if email already exists
    $check_sql = "SELECT id FROM users WHERE email = ?";
    if ($check_stmt = $conn->prepare($check_sql)) {
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            return "Email is already registered.";
        }

        // Insert new user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $insert_sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        if ($insert_stmt = $conn->prepare($insert_sql)) {
            $insert_stmt->bind_param("sss", $name, $email, $hashed_password);
            if ($insert_stmt->execute()) {
                return true;
            } else {
                return "Registration failed: " . $insert_stmt->error;
            }
        } else {
            return "Error preparing insert: " . $conn->error;
        }
    } else {
        return "Error preparing select: " . $conn->error;
    }
}

// Handle JSON input
$data = json_decode(file_get_contents('php://input'), true);

if ($data && isset($data['action'], $data['name'], $data['email'], $data['password'])) {
    $action  = $data['action'];
    $name    = trim($data['name']);
    $email   = trim($data['email']);
    $password = trim($data['password']);

    // Validation
    if (empty($name) || empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => "All fields are required!"]);
        exit;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => "Invalid email format."]);
        exit;
    } else {
        $result = createUser($conn, $name, $email, $password);

        if ($result === true) {
            // Success
            echo json_encode(['success' => true, 'message' => 'User created successfully.']);
            exit;
        } else {
            // Failure
            echo json_encode(['success' => false, 'message' => $result]);
            exit;
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid or missing data.']);
}
$conn->close();
exit;
?>