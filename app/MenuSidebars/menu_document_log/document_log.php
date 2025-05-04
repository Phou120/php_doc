<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Access Logs</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Favicon (Website Logo in Browser Tab) -->
    <link rel="icon" href="../../../../documentation_system/app/images/DocManager.png" type="image/png">
    <style>
    :root {
        --primary: #4361ee;
        --primary-light: #ebf0ff;
        --secondary: #3f37c9;
        --success: #4cc9f0;
        --danger: #f72585;
        --warning: #f8961e;
        --info: #4895ef;
        --dark: #212529;
        --light: #f8f9fa;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: #f5f7fb;
    }

    .sidebar {
        transition: all 0.3s ease;
    }

    .card {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
    }

    .badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-view {
        background-color: #e3f2fd;
        color: #1976d2;
    }

    .badge-download {
        background-color: #e8f5e9;
        color: #388e3c;
    }

    .badge-delete {
        background-color: #ffebee;
        color: #d32f2f;
    }

    .table-row {
        transition: all 0.2s ease;
    }

    .table-row:hover {
        background-color: #f8fafc;
    }

    .search-box {
        transition: all 0.3s ease;
        background-color: #f8fafc;
    }

    .search-box:focus-within {
        background-color: white;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
    }

    .fade-in {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .action-btn {
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        transform: translateY(-2px);
    }
    </style>
</head>

<body class="bg-gray-50">
    <?php
        include_once "doc_log_query.php";
    ?>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?php include 'doc_log_sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">

            <main class="p-6">
                <!-- Header -->
                <?php 
                    include 'doc_log_header.php'; 
                    include 'doc_log_stats_cards.php';
                    include 'doc_log_filter_and_search.php';
                    include 'doc_log_view.php';
                ?>

            </main>
        </div>
    </div>

    <script src="doc_log.js"></script>
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