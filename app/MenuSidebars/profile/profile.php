<?php include_once 'profile_query.php' ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Favicon (Website Logo in Browser Tab) -->
    <link rel="icon" href="../../../../documentation_system/app/images/DocManager.png" type="image/png">
</head>

<body class="bg-gray-100 h-screen w-screen">
    <div class="flex h-full w-full">
        <?php include 'sidebar.php'; ?>

        <main class="flex-1 p-8 overflow-auto">
            <?php 
                include 'header.php'; 
                include 'your_infor.php';
            ?>
        </main>
    </div>

    <!-- Modal Structure -->
    <?php include 'change_password_modal.php'; ?>

    <script src="./js/profile.js"></script>
    <?php if ($success): ?>
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

    document.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1200,
            timerProgressBar: true
        });

        Toast.fire({
            icon: 'success',
            title: 'success',
            text: '<?php echo addslashes($success); ?>',
            confirmButtonText: 'OK'
        });
    });
    </script>
    <?php endif; ?>

    <?php if ($error): ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1200,
            timerProgressBar: true
        });

        Toast.fire({
            icon: 'error',
            title: 'Error',
            text: '<?php echo addslashes($error); ?>',
            confirmButtonText: 'OK'
        });
    });
    </script>
    <?php endif; ?>
</body>

</html>