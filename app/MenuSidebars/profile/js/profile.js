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
          timer: 1000,
          timerProgressBar: true
      });
      
      Toast.fire({
          icon: 'error',
          title: 'Access Denied',
          text: 'You must be logged in to access this page.',
      }).then(() => {
        window.location.href = '../../../../../doc-system/form_login.php'; 
      });
    }
  });
   
 
 
 // Check if user is loaded from localStorage if not already set
 document.addEventListener('DOMContentLoaded', function() {
    // Store the user ID in localStorage for persistence across page navigation
    const formUserIdInput = document.querySelector('form input[name="user_id"]');
    if (formUserIdInput) {
        localStorage.setItem('user_id', formUserIdInput.value);
    } else {
        loadUserFromStorage();
    }
});

// Function to load user data from localStorage
function loadUserFromStorage() {
    const userId = localStorage.getItem('user_id');
    if (!userId) {
        Swal.fire({
            icon: 'error',
            title: 'Not Logged In',
            text: 'No user_id found in localStorage. Please log in again.',
            confirmButtonText: 'Go to Login'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../../../../form_login.php";
            }
        });
    } else {
        // Create and submit a form to reload the page with the user ID
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = window.location.href; // Submit to the same page
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'user_id';
        input.value = userId;
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}

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
            window.location.href = "../../../form_login.php";
        }
    });
}

// Open modal and populate the hidden user ID field with the clicked user's ID
function openModal(userId) {
    document.getElementById('userId').value = userId;
    document.getElementById('changePasswordModal').classList.remove('hidden');

    // Initialize the password change form event listener when the modal is opened
    initPasswordChange();
}

// Close the modal
function closeModal() {
    document.getElementById('changePasswordModal').classList.add('hidden');
}

// Initialize password change functionality
function initPasswordChange() {
    const passwordForm = document.getElementById('changePasswordForm');

    if (passwordForm) {
        // Remove any existing event listeners to prevent duplicates
        const newPasswordForm = passwordForm.cloneNode(true);
        passwordForm.parentNode.replaceChild(newPasswordForm, passwordForm);

        newPasswordForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the form from submitting normally.

            const form = e.target;
            const formData = new FormData(form);

            // Basic validation
            const newPassword = formData.get('new_password');
            const confirmPassword = formData.get('confirm_password');

            if (newPassword !== confirmPassword) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });

                Toast.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'New password and confirmation do not match.'
                });
                return;
            }

            // Perform AJAX request to update the password.
            fetch('../../../users/change_password.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text()) // Receive the result from the PHP backend.
                .then(result => {
                    if (result.trim() === 'Password updated successfully.') {
                        // Success feedback with SweetAlert2
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true
                        });
    
                        Toast.fire({
                            icon: 'success',
                            title: 'Password updated successfully'
                        });

                        // Close the modal after success
                        closeModal();

                        // Reset the form so the user can change their password again if needed
                        form.reset();
                    } else {
                        // Error feedback if the password update fails
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: result
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);

                    // Show a generic error if an exception occurs during the fetch process
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while changing the password.'
                    });
                });
        });
    } else {
        console.error('Password form element not found');
    }
}

function togglePassword(inputId, iconSpan) {
    const input = document.getElementById(inputId);
    const icon = iconSpan.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}