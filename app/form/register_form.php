<?php
session_start();
$name = $_SESSION['signup_name'] ?? '';
$email = $_SESSION['signup_email'] ?? '';
$error = $_SESSION['signup_error'] ?? '';
session_unset(); // Clear session data after using
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
</head>

<body class="bg-gray-100 flex justify-center items-center min-h-screen">

    <div class="bg-white p-10 rounded-2xl shadow-2xl w-full max-w-md">
        <h2 class="text-3xl font-bold text-center text-blue-700 mb-6">Create Your Account</h2>
        <p class="text-center text-gray-500 mb-8 text-sm">It's quick and easy.</p>

        <form action="../users/register.php" method="POST" class="space-y-5">
            <input type="hidden" name="action" value="create" />

            <!-- Name -->
            <div>
                <label for="name" class="block text-gray-600 font-semibold mb-2">Full Name</label>
                <div
                    class="flex items-center border border-gray-300 rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-blue-500">
                    <i class="fas fa-user text-gray-400 mr-2"></i>
                    <input type="text" id="name" name="name" required
                        class="w-full outline-none bg-transparent text-gray-700 placeholder-gray-400"
                        placeholder="John Doe" value="<?= htmlspecialchars($name) ?>">
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-600 font-semibold mb-2">Email Address</label>
                <div
                    class="flex items-center border border-gray-300 rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-blue-500">
                    <i class="fas fa-envelope text-gray-400 mr-2"></i>
                    <input type="email" id="email" name="email" required
                        class="w-full outline-none bg-transparent text-gray-700 placeholder-gray-400"
                        placeholder="you@example.com" value="<?= htmlspecialchars($email) ?>">
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-600 font-semibold mb-2">Password</label>
                <div
                    class="flex items-center border border-gray-300 rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-blue-500">
                    <i class="fas fa-lock text-gray-400 mr-2"></i>
                    <input type="password" id="password" name="password" required
                        class="w-full outline-none bg-transparent text-gray-700 placeholder-gray-400"
                        placeholder="••••••••">
                </div>
            </div>

            <!-- Error Message -->
            <?php if (!empty($error)): ?>
            <div class="text-red-500 text-center text-sm"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit"
                    class="w-full py-3 px-6 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-300">
                    Sign Up
                </button>
            </div>
        </form>

        <!-- Login Redirect -->
        <div class="text-center mt-6">
            <p class="text-gray-600 text-sm">Already have an account?
                <a href="../../form_login.php" class="text-blue-600 font-semibold hover:underline">Login here</a>
            </p>
        </div>
    </div>

</body>

</html>