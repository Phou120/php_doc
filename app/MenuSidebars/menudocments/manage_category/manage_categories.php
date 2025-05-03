<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Font Awesome for file icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body class="bg-gray-50">
    <?php
    // Database connection
    include_once "../../../../connect_db.php";
    $counter = 1;

    // Fetch all documents
    $sql = "SELECT id, name, description FROM document_categories ORDER BY id DESC";
    $result = $conn->query($sql);
    ?>

    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php 
        include 'category_sidebar.php'; 
        ?>

        <main class="flex-1 p-8 overflow-auto">
            <!-- Header -->
            <?php 
                include 'header.php'; 
                include 'actions.php'; 
                include 'modal.php'; 
                include 'category_table.php'; 
                include 'edit_category_modal.php'; 
            ?>

        </main>
    </div>
    <script src="category.js"></script>
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
    </script>
</body>

</html>