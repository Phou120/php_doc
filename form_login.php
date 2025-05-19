<?php
session_start();
include_once './configs/connect_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];

            echo "<script>
                localStorage.setItem('user_id', '" . htmlspecialchars($user['id'], ENT_QUOTES) . "');
                localStorage.setItem('user_name', '" . htmlspecialchars($user['name'], ENT_QUOTES) . "');
                localStorage.setItem('user_email', '" . htmlspecialchars($user['email'], ENT_QUOTES) . "');
                window.location.href = './app/MenuSidebars/dashboard/dashboard.php';
            </script>";
            exit;
        } else {
            echo "<script>alert('Invalid credentials!'); window.location.href = 'form_login.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('No user found with this email!'); window.location.href = 'form_login.php';</script>";
        exit;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Document Management System</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="icon" href="../../../../documentation_system/app/images/DocManager.png" type="image/png">

    <style>
    #togglePassword {
        top: 50%;
        transform: translateY(-50%);
    }
    </style>
</head>

<body class="bg-gray-50">
    <div class="flex justify-center items-center min-h-screen bg-gray-200">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-semibold text-center mb-6">Login</h2>

            <!-- Login Form -->
            <form action="#" method="POST">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-2 pl-10 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter your email">
                        <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-gray-700">Password</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                            class="w-full px-4 py-2 pl-10 pr-10 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Enter your password">
                        <i class="fas fa-lock absolute left-3 top-3 text-gray-400"></i>
                        <i class="fas fa-eye absolute right-3 top-3 text-gray-400 cursor-pointer"
                            id="togglePassword"></i>
                    </div>
                </div>

                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember_me" class="mr-2">
                        <label for="remember_me" class="text-gray-700">Remember me</label>
                    </div>
                    <a href="#" class="text-sm text-blue-600">Forgot Password?</a>
                </div>

                <div class="mb-4">
                    <button type="submit"
                        class="w-full py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Login
                    </button>
                </div>
            </form>

            <div class="text-center">
                <p class="text-gray-600">Don't have an account?
                    <a href="./app/form/register_form.php" class="text-blue-600">Sign up</a>
                </p>
            </div>
        </div>
    </div>

    <!-- JavaScript for password toggle -->
    <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
    </script>
</body>

</html>