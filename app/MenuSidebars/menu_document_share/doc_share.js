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
        window.location.href = '../../../form_login.php'; 
      });
    }
  });
  


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
            window.location.href = "../../../form_login.php";
        }
    });
}