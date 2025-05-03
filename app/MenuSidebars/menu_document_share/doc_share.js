// Automatic search on typing
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');

    // Submit form automatically after a short delay when typing
    searchInput.addEventListener('input', function() {
        // Clear any existing timeout
        if (this.timer) {
            clearTimeout(this.timer);
        }

        // Set a new timeout
        this.timer = setTimeout(() => {
            searchForm.submit();
        }, 500); // 500ms delay before submitting
    });

    // Also handle the case when user clears the input quickly
    searchInput.addEventListener('keydown', function() {
        // Clear any existing timeout on key press
        if (this.timer) {
            clearTimeout(this.timer);
        }
    });
});


// logout user
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