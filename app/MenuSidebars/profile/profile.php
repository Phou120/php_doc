<?php
// user_profile.php
include_once "../../../connect_db.php";

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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body class="bg-gray-100 h-screen w-screen">
    <div class="flex h-full w-full">
        <?php include 'sidebar.php'; ?>

        <main class="flex-1 p-8 overflow-auto">
            <?php 
                include 'header.php'; 
                include 'your_infor.php';
            ?>
        </main>
    </div>

    <!-- Modal Structure -->
    <?php include 'change_password_modal.php'; ?>

    <script src="./js/profile.js"></script>
    <?php if ($success): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check if the user_id, user_name, and user_email exist in localStorage
        const userId = localStorage.getItem('user_id');
        const userName = localStorage.getItem('user_name');
        const userEmail = localStorage.getItem('user_email');

        // If any of these values are missing, redirect to the login page
        if (!userId || !userName || !userEmail) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 500,
                timerProgressBar: true
            });

            Toast.fire({
                icon: 'error',
                title: 'Access Denied',
                text: 'You must be logged in to access this page.',
            }).then(() => {
                window.location.href = '../../../../../documentation_system/form_login.php';
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1200,
            timerProgressBar: true
        });

        Toast.fire({
            icon: 'success',
            title: 'success',
            text: '<?php echo addslashes($success); ?>',
            confirmButtonText: 'OK'
        });
    });
    </script>
    <?php endif; ?>

    <?php if ($error): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1200,
            timerProgressBar: true
        });

        Toast.fire({
            icon: 'error',
            title: 'Error',
            text: '<?php echo addslashes($error); ?>',
            confirmButtonText: 'OK'
        });
    });
    </script>
    <?php endif; ?>
</body>

</html>