<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>


<body class="bg-gray-50">
    <?php
    include_once "../../../connect_db.php";
    $counter = 1;
    $sql = "SELECT id, name, email, created_at FROM users ORDER BY id DESC";
    $result = $conn->query($sql);
    ?>

    <div class="flex h-screen">
        <?php include 'user_sidebar.php'; ?>

        <main class="flex-1 p-8 overflow-auto">
            <?php 
            include 'header.php'; 
            include 'actions.php';
            include 'user_view.php';

            ?>
        </main>
    </div>

    <?php 
        include 'add_user_modal.php'; // Add User Modal
        include '../dashboard/db_modal_structure.php'; 
        include 'edit_user_modal.php'; // Edit User Modal
    ?>

    <!-- JavaScript file -->
    <script src="users.js"></script>


</body>

</html>