const openModalBtn = document.getElementById('openAddUserModal');
const closeModalBtn = document.getElementById('closeAddUserModal');
const modal = document.getElementById('addUserModal');

openModalBtn.addEventListener('click', () => {
    modal.classList.remove('hidden');
});

closeModalBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
});

window.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.classList.add('hidden');
    }
});

function handleLogout() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You will be logged out.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, logout'
    }).then((result) => {
        if (result.isConfirmed) {
            localStorage.removeItem("id");
            localStorage.removeItem("name");
            localStorage.removeItem("email");

            // Redirect to login page
            window.location.href = "../../../../../documentation_system/form_login.php";
        }
    });
}
