<?php
// File: users_handler.php
session_start();
include_once '../../configs/connect_db.php';

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
            return "Error preparing insert statement: " . $conn->error;
        }
    } else {
        return "Error preparing select statement: " . $conn->error;
    }
}

// Function: Add User (admin use)
function addUser($conn, $name, $email, $password) {
    return createUser($conn, $name, $email, $password);
}

// Handle POST submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
    isset($_POST['action'], $_POST['name'], $_POST['email'], $_POST['password'])) {

    $action = $_POST['action'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input
    $validation = validateInput($name, $email, $password);
    if ($validation !== true) {
        $_SESSION['error'] = $validation;
    } else {
        if ($action === 'create') {
            $result = createUser($conn, $name, $email, $password);
            if ($result === true) {
                $_SESSION['success'] = "User registered successfully.";
                header("Location: ../../../../form_login.php");
                exit;
            } else {
                $_SESSION['error'] = $result;
            }
        } elseif ($action === 'add-user') {
            $result = addUser($conn, $name, $email, $password);
            if ($result === true) {
                $_SESSION['success'] = "User added successfully.";
                header("Location: /../../MenuSidebars/menu_users/users.php");
                exit;
            } else {
                $_SESSION['error'] = $result;
            }
        } else {
            $_SESSION['error'] = "Invalid action provided.";
        }
    }

    // Redirect back to form if error occurred
    // if ($action === 'create') {
    //     header("Location: /documentation_system/form_register.php");
    // } elseif ($action === 'add-user') {
    //     header("Location: /documentation_system/app/MenuSidebars/menu_users/create_user_form.php");
    // }
    // exit;
}

$conn->close();
?>