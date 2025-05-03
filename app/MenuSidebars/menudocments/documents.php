<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <style>
    .file-upload-container {
        transition: all 0.3s ease;
    }

    .file-preview-box {
        transition: transform 0.2s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 100%;
        min-height: 120px;
    }

    .file-preview-box:hover {
        transform: scale(1.01);
    }

    .upload-icon-pulse {
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            opacity: 0.7;
        }

        50% {
            opacity: 1;
        }

        100% {
            opacity: 0.7;
        }
    }

    .file-info {
        word-break: break-all;
    }

    #searchContainer {
        background-color: #f9fafb;
        border-radius: 9999px;
        transition: all 0.3s ease;
    }

    #searchContainer.active {
        background-color: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        border: 2px solid #3b82f6;
    }

    #searchInput {
        border: none;
        background: transparent;
        width: 100%;
    }

    #searchInput:focus {
        outline: none;
    }

    .search-results-info {
        transition: all 0.3s ease;
    }
    </style>
</head>

<body class="bg-gray-50">
    <?php
    include_once "../../../connect_db.php";
    $counter = 1;

    $search_term = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

    if (!empty($search_term)) {
        $sql = "SELECT documents.id, documents.title, documents.file_name, documents.file_path, documents.file_type, 
                documents.file_size, documents.uploaded_at, users.name as uploader_name 
                FROM documents 
                JOIN users ON documents.user_id = users.id 
                WHERE documents.title LIKE '%$search_term%'
                ORDER BY documents.id DESC";
    } else {
        $sql = "SELECT documents.id, documents.title, documents.file_name, documents.file_path, documents.file_type, 
                documents.file_size, documents.uploaded_at, users.name as uploader_name 
                FROM documents 
                JOIN users ON documents.user_id = users.id 
                ORDER BY documents.id DESC";
    }

    $result = $conn->query($sql);
    ?>

    <div class="flex h-screen">
        <?php include 'menu_doc_sidebar.php'; ?>

        <main class="flex-1 p-8 overflow-auto">
            <?php
            include 'menu_doc_header.php';
            include 'doc_actions.php';
            include 'doc_upload_modal.php';
            include 'doc_view.php';
            include 'add_new_category_modal.php';
            include 'doc_share_modal.php';
            ?>
        </main>
    </div>

    <?php include 'doc_modal_structure.php'; ?>

    <script src="documents.js"></script>
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