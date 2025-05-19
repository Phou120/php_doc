<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents Shared</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Favicon (Website Logo in Browser Tab) -->
    <link rel="icon" href="../../../assets/images/DocManager.png" type="image/png">
    <link rel="stylesheet" href="../../../assets/css/interface.css">
    <link rel="stylesheet" href="../../../assets/css/document_share.css">
</head>

<body class="bg-gray-50">

    <?php include "document_share_query.php" ?>
    <div class="flex h-screen">
        <?php include '../../../utils/sidebar.php'; ?>

        <main class="flex-1 overflow-auto">
            <div class="p-8 flex-1 overflow-auto">
                <?php
            include 'doc_share_header.php';
            include 'doc_share_view.php';
            ?>
            </div>

            <?php include '../../../utils/footer.php'; ?>

        </main>
    </div>

    <?php include 'doc_modal_structure.php'; ?>

    <script src="doc_share.js"></script>
    <script src="../../../assets/js/sidebar.js"></script>
    <!-- <script>
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
    </script> -->
</body>

</html>