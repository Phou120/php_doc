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
    <link rel="icon" href="../../../assets/images/DocManager.png" type="image/png">
    <link rel="stylesheet" href="../../../assets/css/interface.css">
    <link rel="stylesheet" href="../../../assets/css/document_log.css">
</head>

<body class="bg-gray-50">
    <?php
        include_once "doc_log_query.php";
    ?>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?php include '../../../utils/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">

            <main class="flex-1 overflow-auto">
                <div class="p-8 flex-1 overflow-auto">
                    <!-- Header -->
                    <?php 
                    include 'doc_log_header.php'; 
                    include 'doc_log_stats_cards.php';
                    include 'doc_log_filter_and_search.php';
                    include 'doc_log_view.php';
                ?>
                </div>

                <?php include '../../../utils/footer.php'; ?>

            </main>
        </div>
    </div>

    <script src="doc_log.js"></script>
    <script src="../../../assets/js/sidebar.js"></script>
</body>

</html>