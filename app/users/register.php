<?php
// File: users_handler.php
session_start();
include_once '../../configs/connect_db.php';

// Set response header type
header('Content-Type: application/json');

// Check for CSRF token
// if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
//     http_response_code(403);
//     echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
//     exit;
// }

// Function: Validate Input
function validateInput($name, $email, $password, $confirm_password) {
    $errors = [];
    
    // Name validation
    if (empty($name)) {
        $errors['name'] = "Name is required";
    } elseif (strlen($name) < 2 || strlen($name) > 50) {
        $errors['name'] = "Name must be between 2 and 50 characters";
    }
    
    // Email validation
    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }
    
    // Password validation
    if (empty($password)) {
        $errors['password'] = "ກະລູນາລະຫັດຜ່ານ";
    } elseif (strlen($password) < 8) {
        $errors['password'] = "ລະຫັດຜ່ານຕ້ອງຢ່າງນ້ອຍ 8 ຕົວອັກສອນ";
    } elseif (!preg_match('/[A-Z]/', $password)) {
        $errors['password'] = "ລະຫັດຜ່ານຕ້ອງມີຕົວພິມໃຫຍ່ຢ່າງນ້ອຍ 1 ຕົວ";
    } 
    elseif (!preg_match('/[0-9]/', $password)) {
        $errors['password'] = "ລະຫັດຜ່ານຕ້ອງມີຕົວເລກຢ່າງນ້ອຍ 1 ຕົວ";
    } elseif (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        $errors['password'] = "ລະຫັດຜ່ານຕ້ອງມີຕົວອັກສອນພິເສດຢ່າງນ້ອຍ 1 ຕົວ";
    }
    
    // Confirm password validation
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "ລະຫັດຜ່ານບໍ່ກົງກັນ";
    }
    
    // Terms validation
    if (!isset($_POST['terms']) || $_POST['terms'] !== 'on') {
        $errors['terms'] = "ທ່ານຕ້ອງຕົກລົງເຫັນດີກັບເງື່ອນໄຂການໃຫ້ບໍລິການ";
    }
    
    return empty($errors) ? true : $errors;
}

// Function: Create User
function createUser($conn, $name, $email, $password) {
    try {
        // Check if email exists
        $check_sql = "SELECT id FROM users WHERE email = ? LIMIT 1";
        $check_stmt = $conn->prepare($check_sql);
        
        if (!$check_stmt) {
            throw new Exception("Database error: " . $conn->error);
        }
        
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_stmt->store_result();
        
        if ($check_stmt->num_rows > 0) {
            $check_stmt->close();
            return ["status" => "error", "message" => "ອີເມວຖືກລົງທະບຽນແລ້ວ."];
        }
        $check_stmt->close();
        
        // Hash password with cost factor 12
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
        
        // Insert user
        $insert_sql = "INSERT INTO users (name, email, password, created_at) VALUES (?, ?, ?, NOW())";
        $insert_stmt = $conn->prepare($insert_sql);
        
        if (!$insert_stmt) {
            throw new Exception("Database error: " . $conn->error);
        }
        
        $insert_stmt->bind_param("sss", $name, $email, $hashed_password);
        
        if (!$insert_stmt->execute()) {
            throw new Exception("Registration failed: " . $insert_stmt->error);
        }
        
        $user_id = $insert_stmt->insert_id;
        $insert_stmt->close();
        
        // Store limited user info in session
        $_SESSION['signup_success'] = "ບັນ​ຊີ​ຂອງ​ທ່ານ​ໄດ້​ຮັບ​ການ​ສ້າງ​ສໍາ​ເລັດ​!";
        
        return [
            "status" => "success", 
            "message" => "ຜູ້ໃຊ້ລົງທະບຽນສຳເລັດແລ້ວ.",
            "user_id" => $user_id
        ];
        
    } catch (Exception $e) {
        error_log("Registration error: " . $e->getMessage());
        return ["status" => "error", "message" => "ເກີດຄວາມຜິດພາດໃນລະຫວ່າງການລົງທະບຽນ. ກະລຸນາລອງໃໝ່ໃນພາຍຫຼັງ."];
    }
}

// Main processing logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the request payload
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Store form data in session in case of errors (for form repopulation)
    $_SESSION['signup_name'] = $name;
    $_SESSION['signup_email'] = $email;
    
    // Validate input
    $validation = validateInput($name, $email, $password, $confirm_password);
    
    if ($validation !== true) {
        // Return validation errors
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'ກະລຸນາແກ້ໄຂຂໍ້ຜິດພາດຂ້າງລຸ່ມນີ້.', 'errors' => $validation]);
        exit;
    }
    
    // Process the registration
    $result = createUser($conn, $name, $email, $password);
    
    if ($result['status'] === 'success') {
        // Return success response
        echo json_encode([
            'status' => 'success',
            'message' => 'Registration successful! Redirecting to login page...',
            'redirect' => '../../form_login.php?signup=success'
        ]);
    } else {
        // Return error response
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => $result['message']
        ]);
    }
} else {
    // Method not allowed
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}

$conn->close();
?>