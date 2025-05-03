document.addEventListener('DOMContentLoaded', function () {
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
    addUserModal.addEventListener('click', function (event) {
        // Check if the clicked target is the modal background (outside the modal content)
        if (event.target === addUserModal) {
            closeModal();
        }
    });

    // Add event listener to the form
    form.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Gather the form data as JSON
        const formData = {
            action: 'add-user',
            name: document.getElementById('name').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value
        };

        // Send a fetch request to the PHP script
        fetch('../../../../documentation_system/app/users/register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json' // Indicate that we are sending JSON
            },
            body: JSON.stringify(formData) // Convert the JavaScript object to a JSON string
        })
        .then(response => response.json()) // Assume PHP returns a JSON response
        .then(data => {
            if (data.success) {
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
                form.reset(); // Clear the form after successful submission
                closeModal(); // Hide the modal
            } else {
                // Swal.fire('Error', data.message || 'An error occurred.', 'error');
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });
                
                Toast.fire({
                    icon: 'error',
                    title: 'User Updated Error'
                }).then(() => {
                    location.reload(); // Reload the page after the toast disappears
                });
            }
        })
        .catch(error => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });
            
            Toast.fire({
                icon: 'error',
                title: 'Failed to send request. Please try again.'
            }).then(() => {
                location.reload(); // Reload the page after the toast disappears
            });
            console.error('Error:', error);
        });
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const eyeIcon = document.getElementById('eyeIcon'); // Get the eye icon
    const passwordInput = document.getElementById('password'); // Get the password input field

    // Toggle password visibility
    eyeIcon.addEventListener('click', function () {
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




document.addEventListener('DOMContentLoaded', function () {
    // Ensure the function is in the global scope
    window.openEditModal = function (id, name, email) {
        console.log('openEditModal called with:', id, name, email); // Debugging line
        document.getElementById('edit-id').value = id;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-email').value = email;
        document.getElementById('editUserModal').classList.remove('hidden');
    };

    window.closeModal = function () {
        document.getElementById('editUserModal').classList.add('hidden');
    };

    // Form submission handling
    document.getElementById('editUserForm').addEventListener('submit', function (e) {
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
                body: JSON.stringify({ id: userId })
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

