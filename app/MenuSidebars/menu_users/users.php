<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Favicon (Website Logo in Browser Tab) -->
    <link rel="icon" href="../../../assets/images/DocManager.png" type="image/png">
    <link rel="stylesheet" href="../../../assets/css/interface.css">
</head>


<body class="bg-gray-50">
    <?php
        include_once "user_query.php";
    ?>

    <div class="flex h-screen">
        <?php include '../../../utils/sidebar.php'; ?>

        <main class="flex-1 overflow-auto">
            <div class="p-8 flex-1 overflow-auto">
                <?php 
            include 'header.php'; 
            include 'actions.php';
            include 'user_view.php';

            ?>
            </div>

            <?php include '../../../utils/footer.php'; ?>
        </main>
    </div>

    <?php 
        include 'add_user_modal.php'; // Add User Modal
        include '../dashboard/db_modal_structure.php'; 
        include 'edit_user_modal.php'; // Edit User Modal
    ?>

    <!-- JavaScript file -->
    <script src="users.js"></script>
    <script src="../../../assets/js/sidebar.js"></script>

</body>

</html>