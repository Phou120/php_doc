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
  

  // logout
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


document.addEventListener('DOMContentLoaded', function() {
    // Get modal elements
    const openModalButton = document.getElementById('openModalButton');
    const closeModalButton = document.getElementById('closeModalButton');
    const modal = document.getElementById('addCategoryModal');
    const form = document.getElementById('addCategoryForm');

    // Open modal when clicking "Add Category"
    openModalButton.addEventListener('click', function() {
        modal.classList.remove('hidden');
    });

    // Close modal when clicking "Cancel"
    closeModalButton.addEventListener('click', function() {
        modal.classList.add('hidden');
    });

    // Handle form submission
    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const categoryName = document.getElementById('category_name').value.trim();
        const description = document.getElementById('description').value.trim();

        if (!categoryName) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });

            Toast.fire({
                icon: 'error',
                title: 'Created Category Error'
            }).then(() => {
                location.reload(); // Reload the page after the toast disappears
            });
        }

        const data = {
            category_name: categoryName,
            description: description
        };

        try {
            const response = await fetch(
                '../../Category/save_category.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

            const result = await response.json();

            if (result.success) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Created Category successfully'
                }).then(() => {
                    location.reload(); // Reload the page after the toast disappears
                });
                closeModalButton.click(); // Close modal after successful submission
                form.reset();
            } else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });

                Toast.fire({
                    icon: 'error',
                    title: 'This Category Already Exists',
                });
            }
        } catch (error) {
            Swal.fire('Error', 'Something went wrong.', 'error');
            console.error(error);
        }
    });
});



function openEditModal(category) {
    document.getElementById('edit_category_id').value = category.id;
    document.getElementById('edit_category_name').value = category.name;
    document.getElementById('edit_description').value = category.description;
    document.getElementById('editCategoryModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editCategoryModal').classList.add('hidden');
}

document.getElementById('editCategoryForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const id = document.getElementById('edit_category_id').value;
    const name = document.getElementById('edit_category_name').value.trim();
    const description = document.getElementById('edit_description').value.trim();

    try {
        const response = await fetch(
            '../../Category/update_category.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id,
                    name,
                    description
                })
            });

        const result = await response.json();

        if (result.success) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });

            Toast.fire({
                icon: 'success',
                title: 'Category Updated successfully'
            }).then(() => {
                location.reload(); // Reload the page after the toast disappears
            });
        } else {

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });

            Toast.fire({
                icon: 'error',
                title: result.message
            });
        }
    } catch (err) {
        console.error(err);
        Swal.fire('Error', 'Something went wrong', 'error');
    }
});

// ✅ Close modal when clicking outside
document.getElementById('editCategoryModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditModal();
    }
});

// ✅ Optional: Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditModal();
    }
});


// delete
function confirmDeleteCategory(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'You won’t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const response = await fetch(
                    '../../Category/delete_category.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id
                        })
                    });

                const result = await response.json();

                if (result.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Deleted successfully',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        location.reload(); // Reload the page after the toast disappears
                    });
                } else {
                    Swal.fire('Error', result.message || 'Failed to delete', 'error');
                }
            } catch (error) {
                Swal.fire('Error', 'Something went wrong', 'error');
            }
        }
    });
}