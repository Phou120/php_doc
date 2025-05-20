<?php
session_start();

// Enhanced security with stronger CSRF protection
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// More robust flash message handling
function getFlash($key) {
    $value = $_SESSION[$key] ?? null;
    unset($_SESSION[$key]);
    return $value;
}

// Retrieve flash messages and form data
$name = getFlash('signup_name') ?? '';
$email = getFlash('signup_email') ?? '';
$error = getFlash('signup_error') ?? '';
$success = getFlash('signup_success') ?? '';
?>