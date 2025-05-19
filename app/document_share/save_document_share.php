<?php

// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set response to JSON
header('Content-Type: application/json');

// Autoload PHPMailer
require_once '../../vendor/autoload.php';
include_once "../../configs/connect_db.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Read JSON input
$data = json_decode(file_get_contents('php://input'), true);
$document_id = isset($data['document_id']) ? intval($data['document_id']) : null;
$email = isset($data['email']) ? trim($data['email']) : null;

// Validate input
if (!$document_id || !$email) {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    exit;
}

try {
    // Insert share record
    $stmt = $conn->prepare("INSERT INTO document_shares (document_id, shared_with_email) VALUES (?, ?)");
    $stmt->bind_param("is", $document_id, $email);
    $stmt->execute();

    // Get document title
    $stmt = $conn->prepare("SELECT title, file_name, file_path FROM documents WHERE id = ?");
    $stmt->bind_param("i", $document_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $document = $result->fetch_assoc();

    if (!$document) {
        echo json_encode(['success' => false, 'message' => 'Document not found.']);
        exit;
    }
    

    // Send email using PHPMailer
    $mail = new PHPMailer(true);

    // SMTP config
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com'; // Change if using another SMTP
    $mail->SMTPAuth   = true;
    $mail->Username   = 'phou991@gmail.com'; // Your email
    $mail->Password   = 'bbihxagkrlvexsfy'; // App password or SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('noreply@yourdomain.com', 'Document System');
    $mail->addAddress($email);
    // Create an HTML body for the email
    $mail->isHTML(true);  // Set email format to HTML
    $mail->Subject = 'Document Shared with You';
    // Beautifully styled email body
    $mail->Body = "
    <html>
    <head>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
            
            body {
                font-family: 'Poppins', Arial, sans-serif;
                background-color: #f8f9fa;
                margin: 0;
                padding: 0;
                color: #495057;
                line-height: 1.6;
            }
            .container {
                width: 100%;
                max-width: 640px;
                margin: 30px auto;
                background-color: #ffffff;
                border-radius: 12px;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
                overflow: hidden;
            }
            .header {
                text-align: center;
                padding: 30px 20px;
                background: linear-gradient(135deg, #4766EEFF 0%);
                color: #ffffff;
            }
            .header h2 {
                margin: 0;
                font-weight: 600;
                font-size: 28px;
            }
            .content {
                padding: 30px;
            }
            .document-info {
                background-color: #f8f9fa;
                border-radius: 8px;
                padding: 20px;
                margin: 20px 0;
            }
            .info-row {
                display: flex;
                margin-bottom: 12px;
            }
            .info-label {
                font-weight: 500;
                color: #6c757d;
                min-width: 100px;
            }
            .info-value {
                font-weight: 400;
                color: #343a40;
            }
            .button-container {
                text-align: center;
                margin: 30px 0;
            }
            .button {
                display: inline-block;
                padding: 14px 32px;
                background: linear-gradient(135deg, #CBCCCFFF 0%);
                color: black;
                text-decoration: none;
                border-radius: 30px;
                font-size: 16px;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            .button:hover {
                transform: translateY(-2px);
            }
            .footer {
                text-align: center;
                padding: 20px;
                background-color: #f1f3f5;
                font-size: 14px;
                color: #868e96;
            }
            .logo {
                font-weight: 600;
                color: #764ba2;
                font-size: 16px;
                margin-top: 10px;
            }
            .divider {
                height: 1px;
                background: linear-gradient(to right, transparent, #dee2e6, transparent);
                margin: 25px 0;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>New Document Shared With You</h2>
            </div>
            
            <div class='content'>
                <p>Hello,</p>
                <p>You've received a new document shared with you. Here are the details:</p>
                
                <div class='document-info'>
                    <div class='info-row'>
                        <div class='info-label'>Title:</div>
                        <div class='info-value'>" . $document['title'] . "</div>
                    </div>
                    <div class='info-row'>
                        <div class='info-label'>File Name:</div>
                        <div class='info-value'>" . $document['file_name'] . "</div>
                    </div>
                </div>
                
                <div class='divider'></div>
                
                <div class='button-container'>
                    <a href='http://localhost/documentation_system/" . $document['file_path'] . "' target='_blank' class='button'>View Document</a>
                </div>
                
                <p>If you have any questions about this document, please contact the sender directly.</p>
            </div>
            
            <div class='footer'>
                <p>This is an automated message. Please do not reply to this email.</p>
                <div class='logo'>Document Management System</div>
            </div>
        </div>
    </body>
    </html>
    ";

    $mail->send();

    echo json_encode(['success' => true, 'message' => 'Document shared successfully.']);
} catch (Exception $e) {
    // Log error for debugging
    file_put_contents('log.txt', $e->getMessage() . PHP_EOL, FILE_APPEND);

    // Send error response
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}
?>