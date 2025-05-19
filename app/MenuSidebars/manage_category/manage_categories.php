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
    <!-- Favicon (Website Logo in Browser Tab) -->
    <link rel="icon" href="../../../assets/images/DocManager.png" type="image/png">
    <link rel="stylesheet" href="../../../assets/css/interface.css">
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">
    <?php include_once 'manage_category_query.php'; ?>

    <div class="flex flex-1">
        <!-- Sidebar -->
        <?php include '../../../utils/sidebar.php'; ?>

        <main class="flex-1 overflow-auto">
            <div class="p-8 flex-1 overflow-auto">
                <!-- Header -->
                <?php 
                    include 'header.php'; 
                    include 'actions.php'; 
                    include 'modal.php'; 
                    include 'category_table.php'; 
                    include 'edit_category_modal.php'; 
                ?>
            </div>

            <!-- Footer -->
            <?php include '../../../utils/footer.php'; ?>

        </main>
    </div>
    <script src="category.js"></script>
    <script src="../../../assets/js/sidebar.js"></script>
</body>

</html>