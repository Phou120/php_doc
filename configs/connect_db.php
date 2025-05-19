<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load .env from the project root
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Database connection details from .env
$servername = $_ENV['SERVERNAME'];
$username   = $_ENV['DB_USERNAME'];
$password   = $_ENV['DB_PASSWORD'];
$dbname     = $_ENV['DB_NAME'];

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}