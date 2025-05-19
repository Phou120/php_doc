<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Favicon (Website Logo in Browser Tab) -->
    <link rel="icon" href="../../../assets/images/DocManager.png" type="image/png">
    <link rel="stylesheet" href="../../../assets/css/interface.css">
    <link rel="stylesheet" href="../../../assets/css/documents.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'P', sans-serif;
    }
    </style>
</head>

<body class="bg-gray-50">
    <?php
    include_once "document_query.php";
    ?>

    <div class="flex h-screen">
        <?php include '../../../utils/sidebar.php'; ?>

        <main class="flex-1 overflow-auto">
            <div class="p-8 flex-1 overflow-auto">
                <?php
                include 'menu_doc_header.php';
                include 'doc_actions.php';
                include 'doc_upload_modal.php';
                include 'doc_view.php';
                include 'add_new_category_modal.php';
                include 'doc_share_modal.php';
                ?>
            </div>

            <?php include '../../../utils/footer.php'; ?>
        </main>
    </div>

    <?php include 'doc_modal_structure.php'; ?>

    <script src="documents.js"></script>
    <script src="../../../assets/js/sidebar.js"></script>
</body>

</html>