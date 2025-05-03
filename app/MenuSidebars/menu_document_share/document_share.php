<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents Shared</title>
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

    $sql = "
        SELECT document_shares.*, documents.title, documents.file_name, documents.file_path
        FROM document_shares
        JOIN documents ON document_shares.document_id = documents.id
        WHERE documents.title LIKE '%$search_term%' 
        OR document_shares.shared_with_email LIKE '%$search_term%'
        ORDER BY document_shares.id DESC
    ";


    $result = $conn->query($sql);
    ?>

    <div class="flex h-screen">
        <?php include 'doc_share_sidebar.php'; ?>

        <main class="flex-1 p-8 overflow-auto">
            <?php
            include 'doc_share_header.php';
            include 'doc_share_view.php';
            ?>

        </main>
    </div>

    <?php include 'doc_modal_structure.php'; ?>

    <script src="doc_share.js"></script>
</body>

</html>