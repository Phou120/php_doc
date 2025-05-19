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

  
  //   function logoutUser() {
  //     // Debug: See if keys exist
  //     console.log("Before logout:", {
  //         id: localStorage.getItem("id"),
  //         name: localStorage.getItem("name"),
  //         email: localStorage.getItem("email")
  //     });

  //     // Remove specific keys
  //     localStorage.removeItem("id");
  //     localStorage.removeItem("name");
  //     localStorage.removeItem("email");

  //     // Debug: Check after removal
  //     console.log("After logout:", {
  //         id: localStorage.getItem("id"),
  //         name: localStorage.getItem("name"),
  //         email: localStorage.getItem("email")
  //     });

  //     // Redirect
  //     window.location.href = "../../form_login.php"; // update path as needed
  // }
