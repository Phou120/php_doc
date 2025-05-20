<?php include_once 'register-session.php'?>

<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Create your account to access premium features">
    <title>Sign Up | DocManager</title>

    <!-- Preload critical resources -->
    <link rel="preload" href="https://cdn.tailwindcss.com" as="script">
    <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" as="style">

    <!-- Favicon with multiple sizes -->
    <link rel="icon" href="../../assets/images/DocManager.png" type="image/png" sizes="32x32">
    <link rel="icon" href="../../assets/images/DocManager.svg" type="image/svg+xml">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="../../assets/js/tailwind.config.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom styles -->
    <link rel="stylesheet" href="../../assets/css/register.css">
</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white p-8 sm:p-10 rounded-2xl shadow-xl w-full max-w-md mx-4 relative overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute -top-20 -right-20 w-40 h-40 bg-primary-600/10 rounded-full"></div>
        <div class="absolute -bottom-20 -left-20 w-40 h-40 bg-primary-600/10 rounded-full"></div>

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="../../assets/images/DocManager.png" alt="DocManager Logo" class="h-12">
        </div>

        <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">Create Your Account</h1>
        <p class="text-center text-gray-500 mb-8 text-sm">Join thousands of professionals managing their documents</p>

        <?php 
            // Message
            include_once 'message.php';
            // Input Fields
            include_once 'form-input-data.php';
            //  Login Redirect
            include_once 'btn.php';
        ?>

    </div>

    <script src="../../assets/js/register.js"></script>
</body>

</html>