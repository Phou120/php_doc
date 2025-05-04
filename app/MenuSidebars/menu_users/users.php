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
    <link rel="icon" href="../../../../documentation_system/app/images/DocManager.png" type="image/png">
    <link rel="stylesheet" href="../../../../documentation_system/css/interface.css">

</head>


<body class="bg-gray-50">
    <?php
        include_once "user_query.php";
    ?>

    <div class="flex h-screen">
        <?php include '../../../../documentation_system/app/sidebar.php'; ?>

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
    <!-- <script src="users.js"></script> -->
    <script src="../../../../documentation_system/js/sidebar.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('addUserForm'); // Select the form
        const addUserModal = document.getElementById('addUserModal'); // Get the modal for adding users
        const closeAddUserModal = document.getElementById('closeAddUserModal'); // Close button for the modal
        const openAddUserModal = document.getElementById('openAddUserModal'); // Button to open the modal

        // Function to open the modal
        function openModal() {
            addUserModal.classList.remove('hidden');
        }

        // Function to close the modal
        function closeModal() {
            addUserModal.classList.add('hidden');
        }

        // Open the modal when the open button is clicked
        openAddUserModal.addEventListener('click', openModal);

        // Close the modal when the close button is clicked
        closeAddUserModal.addEventListener('click', closeModal);

        // Close the modal when clicking outside the modal content
        addUserModal.addEventListener('click', function(event) {
            // Check if the clicked target is the modal background (outside the modal content)
            if (event.target === addUserModal) {
                closeModal();
            }
        });

        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = {
                action: 'add-user',
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value
            };

            fetch('../../../../documentation_system/app/users/create_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });

                    if (data.success) {
                        Toast.fire({
                            icon: 'success',
                            title: data.message || 'User created successfully'
                        }).then(() => {
                            location.reload();
                        });
                        form.reset();
                        closeModal();
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message || 'User creation failed'
                        });
                    }
                })
        });
    });


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
        const eyeIcon = document.getElementById('eyeIcon'); // Get the eye icon
        const passwordInput = document.getElementById('password'); // Get the password input field

        // Toggle password visibility
        eyeIcon.addEventListener('click', function() {
            if (passwordInput.type === "password") {
                passwordInput.type = "text"; // Show password
                eyeIcon.classList.remove('fa-eye'); // Change icon to open eye
                eyeIcon.classList.add('fa-eye-slash'); // Change icon to eye-slash
            } else {
                passwordInput.type = "password"; // Hide password
                eyeIcon.classList.remove('fa-eye-slash'); // Change icon to closed eye
                eyeIcon.classList.add('fa-eye'); // Change icon to eye
            }
        });
    });




    function handleLogout() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, logout',
            position: 'top-end',
            timer: 0,
            showConfirmButton: true,
            showLoaderOnConfirm: true,
            toast: true,
            timerProgressBar: true,
            customClass: {
                popup: 'swal2-small-popup'
            },
            preConfirm: () => {
                localStorage.removeItem("user_id");
                localStorage.removeItem("user_name");
                localStorage.removeItem("user_email");
                window.location.href = "../../../../../documentation_system/form_login.php";
            }
        });
    }




    document.addEventListener('DOMContentLoaded', function() {
        // Ensure the function is in the global scope
        window.openEditModal = function(id, name, email) {
            console.log('openEditModal called with:', id, name, email); // Debugging line
            document.getElementById('edit-id').value = id;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('editUserModal').classList.remove('hidden');
        };

        window.closeModal = function() {
            document.getElementById('editUserModal').classList.add('hidden');
        };

        // Form submission handling
        document.getElementById('editUserForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const userData = {
                id: document.getElementById('edit-id').value,
                name: document.getElementById('edit-name').value,
                email: document.getElementById('edit-email').value
            };

            fetch('../../../../../documentation_system/app/users/edit_user.php', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(userData)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Show a brief toast notification instead of a modal that requires clicking
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true
                        });

                        Toast.fire({
                            icon: 'success',
                            title: 'User Updated successfully'
                        }).then(() => {
                            location.reload(); // Reload the page after the toast disappears
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Error', 'Failed to update user.', 'error');
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true
                    });

                    Toast.fire({
                        icon: 'error',
                        title: 'error',
                        text: 'Failed to update user.',
                    }).then(() => {
                        location.reload(); // Reload the page after the toast disappears
                    });
                });
        });
    });


    function deleteUser(event, userId) {
        event.preventDefault(); // Prevent the default link behavior

        // Trigger the SweetAlert confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with deletion via AJAX
                fetch('../../../../documentation_system/app/users/delete.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            id: userId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show a brief toast notification instead of a modal that requires clicking
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true
                            });

                            Toast.fire({
                                icon: 'success',
                                title: 'User deleted successfully'
                            }).then(() => {
                                location.reload(); // Reload the page after the toast disappears
                            });
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Failed to delete user.', 'error');
                    });
            }
        });
    }
    </script>

</body>

</html>