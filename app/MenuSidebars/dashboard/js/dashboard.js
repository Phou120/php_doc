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
      window.location.href = '../../../../form_login.php'; 
    });
  }
});



// Dropdown functionality
document.querySelectorAll('.dropdown button').forEach(button => {
    button.addEventListener('click', (e) => {
    e.stopPropagation();
    const dropdown = button.closest('.dropdown');
    const menu = dropdown.querySelector('.dropdown-menu');
    menu.classList.toggle('hidden');
    });
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', () => {
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
    menu.classList.add('hidden');
    });
    });
    
    // Modal functionality for previews
    document.querySelectorAll('.file-thumbnail').forEach(thumbnail => {
    thumbnail.addEventListener('click', () => {
    const modal = document.getElementById('fileModal');
    const modalContent = document.getElementById('modalFileContent');
    const modalTitle = document.getElementById('modalTitle');
    
    modalTitle.textContent = thumbnail.dataset.title;
    
    if (thumbnail.dataset.type === 'image') {
    modalContent.innerHTML =
    `<img src="${thumbnail.dataset.file}" class="w-full max-h-[70vh] object-contain">`;
    } else if (thumbnail.dataset.type === 'pdf') {
    modalContent.innerHTML =
    `<iframe src="${thumbnail.dataset.file}" class="w-full h-[70vh]"></iframe>`;
    }
    
    modal.classList.remove('hidden');
    });
    });
    
    // Close modal
    document.querySelector('.close').addEventListener('click', () => {
    document.getElementById('fileModal').classList.add('hidden');
    });
    
    
    const ctx = document.getElementById('uploadChart').getContext('2d');
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
              label: 'Files Uploaded',
              data: [4, 7, 3, 5, 6, 2, 8],
              backgroundColor: 'rgba(59, 130, 246, 0.5)',
              borderColor: 'rgba(59, 130, 246, 1)',
              borderWidth: 1,
              borderRadius: 6,
            }]
          },
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: false
              }
            },
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });


// function handleLogout() {
//   Swal.fire({
//       title: 'Are you sure?',
//       text: "You will be logged out.",
//       icon: 'warning',
//       showCancelButton: true,
//       confirmButtonColor: '#3085d6',
//       cancelButtonColor: '#d33',
//       confirmButtonText: 'Yes, logout',
//       position: 'top-end',
//       timer: 0,
//       showConfirmButton: true,
//       showLoaderOnConfirm: true,
//       toast: true,
//       timerProgressBar: true,
//       customClass: {
//           popup: 'swal2-small-popup'
//       },
//       preConfirm: () => {
//           localStorage.removeItem("user_id");
//           localStorage.removeItem("user_name");
//           localStorage.removeItem("user_email");
//           // window.location.href = "../../../../../";
//       }
//   });
// }

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
            window.location.href = "../../../MenuSidebars/menudocments/documents.php";
        }
    });
}