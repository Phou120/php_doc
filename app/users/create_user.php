<?php
include_once '../../configs/connect_db.php';
session_start();

// Set headers for JSON response
header('Content-Type: application/json');

// Function: Validate Input
function validateInput($name, $email, $password) {
    if (empty($name) || empty($email) || empty($password)) {
        return "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format.";
    } elseif (strlen($password) < 6) {
        return "Password must be at least 6 characters.";
    }
    return true;
}

// Function: Create User
function createUser($conn, $name, $email, $password) {
    $check_sql = "SELECT id FROM users WHERE email = ? LIMIT 1";
    if ($check_stmt = $conn->prepare($check_sql)) {
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            return "Email is already registered.";
        }

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

// Handle POST form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get raw POST data
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['action'], $data['name'], $data['email'], $data['password'])) {
        $action = $data['action'];
        $name = trim($data['name']);
        $email = trim($data['email']);
        $password = trim($data['password']);

        // Validate input
        $validation = validateInput($name, $email, $password);
        if ($validation !== true) {
            echo json_encode(['success' => false, 'message' => $validation]);
            exit;
        }

        if ($action === 'add-user') {
            $result = createUser($conn, $name, $email, $password);
            if ($result === true) {
                echo json_encode(['success' => true, 'message' => 'User created successfully.']);
                exit;
            } else {
                echo json_encode(['success' => false, 'message' => $result]);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid action.']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
        exit;
    }
}

$conn->close();
echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
?>