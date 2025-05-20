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

        <!-- Success Message -->
        <?php if (!empty($success)): ?>
        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-lg border border-green-200 flex items-start">
            <i class="fas fa-check-circle mt-1 mr-3 text-green-500"></i>
            <div>
                <p class="font-medium"><?= htmlspecialchars($success) ?></p>
                <p class="text-sm mt-1">You can now <a href="../../form_login.php"
                        class="text-green-600 font-medium hover:underline">login</a> to your account.</p>
            </div>
        </div>
        <?php endif; ?>

        <form id="signupForm" class="space-y-5" novalidate>

            <!-- Name -->
            <div>
                <label for="name" class="block text-gray-600 font-medium mb-2">Full Name</label>
                <div class="relative">
                    <div
                        class="flex items-center border border-gray-300 rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-primary-600 focus-within:border-transparent transition-all duration-200">
                        <i class="fas fa-user text-gray-400 mr-2"></i>
                        <input type="text" id="name" name="name" required minlength="2" maxlength="50"
                            class="w-full outline-none bg-transparent text-gray-700 placeholder-gray-400 peer"
                            placeholder="John Doe" value="<?= htmlspecialchars($name) ?>">
                    </div>
                    <div id="name-error" class="form-error hidden"></div>
                </div>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-600 font-medium mb-2">Email Address</label>
                <div class="relative">
                    <div
                        class="flex items-center border border-gray-300 rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-primary-600 focus-within:border-transparent transition-all duration-200">
                        <i class="fas fa-envelope text-gray-400 mr-2"></i>
                        <input type="email" id="email" name="email" required
                            class="w-full outline-none bg-transparent text-gray-700 placeholder-gray-400 peer"
                            placeholder="you@example.com" value="<?= htmlspecialchars($email) ?>">
                    </div>
                    <div id="email-error" class="form-error hidden"></div>
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-600 font-medium mb-2">Password</label>
                <div class="relative">
                    <div
                        class="flex items-center border border-gray-300 rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-primary-600 focus-within:border-transparent transition-all duration-200">
                        <i class="fas fa-lock text-gray-400 mr-2"></i>
                        <input type="password" id="password" name="password" required minlength="8"
                            class="w-full outline-none bg-transparent text-gray-700 placeholder-gray-400 peer"
                            placeholder="••••••••">
                        <button type="button"
                            class="text-gray-400 hover:text-gray-600 focus:outline-none toggle-password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="mt-1 flex items-center">
                        <div class="w-full bg-gray-200 rounded-full h-1">
                            <div id="password-strength" class="password-strength-meter h-1 rounded-full"
                                style="width: 0%"></div>
                        </div>
                        <span id="password-strength-text" class="ml-2 text-xs text-gray-500"></span>
                    </div>
                    <ul class="mt-2 text-xs text-gray-500 list-disc list-inside">
                        <li id="length-requirement" class="text-gray-400">Minimum 8 characters</li>
                        <li id="uppercase-requirement" class="text-gray-400">At least one uppercase letter</li>
                        <li id="number-requirement" class="text-gray-400">At least one number</li>
                        <li id="special-requirement" class="text-gray-400">At least one special character</li>
                    </ul>
                    <div id="password-error" class="form-error hidden"></div>
                </div>
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="confirm_password" class="block text-gray-600 font-medium mb-2">Confirm Password</label>
                <div class="relative">
                    <div
                        class="flex items-center border border-gray-300 rounded-lg px-3 py-2 focus-within:ring-2 focus-within:ring-primary-600 focus-within:border-transparent transition-all duration-200">
                        <i class="fas fa-lock text-gray-400 mr-2"></i>
                        <input type="password" id="confirm_password" name="confirm_password" required minlength="8"
                            class="w-full outline-none bg-transparent text-gray-700 placeholder-gray-400 peer"
                            placeholder="••••••••">
                        <button type="button"
                            class="text-gray-400 hover:text-gray-600 focus:outline-none toggle-password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div id="confirm-password-error" class="form-error hidden"></div>
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="terms" name="terms" type="checkbox" required
                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-2 focus:ring-primary-600">
                </div>
                <label for="terms" class="ml-2 text-sm text-gray-600">
                    I agree to the <a href="/terms" class="text-primary-600 hover:underline">Terms of Service</a> and
                    <a href="/privacy" class="text-primary-600 hover:underline">Privacy Policy</a>
                </label>
            </div>
            <div id="terms-error" class="form-error hidden"></div>

            <!-- Global Error Message -->
            <div id="global-error"
                class="p-4 bg-red-50 text-red-700 rounded-lg border border-red-200 flex items-start animate-shake hidden">
                <i class="fas fa-exclamation-circle mt-1 mr-3 text-red-500"></i>
                <div id="global-error-message"></div>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" id="submitBtn"
                    class="w-full py-3 px-6 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 transition-all duration-200 flex justify-center items-center">
                    <span id="btnText">Sign Up</span>
                    <svg id="spinner" class="hidden w-5 h-5 ml-2 text-white animate-spin"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </button>
            </div>
        </form>

        <!-- Login Redirect -->
        <div class="text-center mt-6 pt-4 border-t border-gray-200">
            <p class="text-gray-600 text-sm">Already have an account?
                <a href="../../form_login.php"
                    class="text-primary-600 font-medium hover:underline transition-all duration-200">Login here</a>
            </p>
        </div>
    </div>

    <script src="../../assets/js/register.js"></script>
</body>

</html>