
    
    
    
      
function logoutUser() {
    // Debug: See if keys exist
    console.log("Before logout:", {
        id: localStorage.getItem("id"),
        name: localStorage.getItem("name"),
        email: localStorage.getItem("email")
    });

    // Remove specific keys
    localStorage.removeItem("id");
    localStorage.removeItem("name");
    localStorage.removeItem("email");

    // Debug: Check after removal
    console.log("After logout:", {
        id: localStorage.getItem("id"),
        name: localStorage.getItem("name"),
        email: localStorage.getItem("email")
    });

    // Redirect
    window.location.href = "../../form_login.php"; // update path as needed
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
            window.location.href = "../../../../../documentation_system/form_login.php";
        }
    });
}

  // upload
  document.addEventListener('DOMContentLoaded', function() {
    // Fetch categories to populate the dropdown
    fetch('get_categories.php')
        .then(response => response.json())
        .then(categories => {
            const categorySelect = document.getElementById('category');
            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error fetching categories:', error);
        });

    const dropArea = document.getElementById('drop-area');
    const fileInput = document.getElementById('fileInput');
    const initialState = document.getElementById('initialState');
    const selectedState = document.getElementById('selectedState');
    const filePreview = document.getElementById('filePreview');
    const fileNameLabel = document.getElementById('fileNameLabel');

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false)
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // Highlight drop area when item is dragged over it
    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false)
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false)
    });

    function highlight(e) {
        dropArea.classList.add('border-blue-500', 'bg-blue-100');
        dropArea.classList.remove('from-blue-50', 'to-indigo-50');
    }

    function unhighlight(e) {
        dropArea.classList.remove('border-blue-500', 'bg-blue-100');
        dropArea.classList.add('from-blue-50', 'to-indigo-50');
    }

    // Handle dropped files
    dropArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        fileInput.files = files;
        handleFileChange(files[0]);
    }

    // Trigger file input click when drop area is clicked
    dropArea.addEventListener('click', () => {
        fileInput.click();
    });

    // Handle file input change
    fileInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            handleFileChange(this.files[0]);
        }
    });

    function handleFileChange(file) {
        // Reset previous preview
        filePreview.innerHTML = '';

        if (file) {
            // Show selected state, hide initial state
            initialState.classList.add('hidden');
            selectedState.classList.remove('hidden');

            // Set file name
            fileNameLabel.textContent = file.name;

            const fileType = file.type;
            const fileName = file.name;

            // Check file type and display appropriate icon or preview
            if (fileType === 'application/pdf') {
                filePreview.innerHTML = `
                    <div class="w-full h-full flex flex-col items-center justify-center p-4">
                        <i class="fas fa-file-pdf text-red-600 text-5xl mb-2"></i>
                        <span class="text-sm text-gray-600">PDF Document</span>
                    </div>`;
            } else if (fileType.includes('word') || fileName.endsWith('.doc') || fileName.endsWith(
                    '.docx')) {
                filePreview.innerHTML = `
                    <div class="w-full h-full flex flex-col items-center justify-center p-4">
                        <i class="fas fa-file-word text-blue-600 text-5xl mb-2"></i>
                        <span class="text-sm text-gray-600">Word Document</span>
                    </div>`;
            } else if (fileType.includes('excel') || fileName.endsWith('.xls') || fileName.endsWith(
                    '.xlsx')) {
                filePreview.innerHTML = `
                    <div class="w-full h-full flex flex-col items-center justify-center p-4">
                        <i class="fas fa-file-excel text-green-600 text-5xl mb-2"></i>
                        <span class="text-sm text-gray-600">Excel Spreadsheet</span>
                    </div>`;
            } else if (fileType.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    filePreview.innerHTML = `
                        <div class="w-full h-full flex flex-col items-center justify-center">
                            <img src="${e.target.result}" class="max-h-full max-w-full object-contain" alt="Preview">
                        </div>`;
                };
                reader.readAsDataURL(file);
            } else {
                filePreview.innerHTML = `
                    <div class="w-full h-full flex flex-col items-center justify-center p-4">
                        <i class="fas fa-file text-gray-600 text-5xl mb-2"></i>
                        <span class="text-sm text-gray-600">${file.name}</span>
                    </div>`;
            }
        } else {
            // No file selected - show initial state
            initialState.classList.remove('hidden');
            selectedState.classList.add('hidden');
        }
    }

    // Modal controls
    document.getElementById('uploadBtn').addEventListener('click', () => {
        const modal = document.getElementById('uploadModal');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.querySelector('div').classList.add('scale-100');
            modal.querySelector('div').classList.remove('scale-95');
        }, 10);
    });

    // Close modal when Cancel or X button is clicked
    document.getElementById('closeModal').addEventListener('click', closeModal);
    document.getElementById('closeModalX').addEventListener('click', closeModal);

    function closeModal() {
        const modal = document.getElementById('uploadModal');
        modal.querySelector('div').classList.add('scale-95');
        modal.querySelector('div').classList.remove('scale-100');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Handle the form submission
    document.getElementById('uploadForm').addEventListener('submit', async function(event) {
        event.preventDefault();

        const formData = new FormData(this);
        const submitBtn = document.getElementById('submitUploadBtn');

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Uploading...';

        try {
            const response = await fetch('upload_document.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Document uploaded successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.reload();
                });
                document.getElementById('uploadForm').reset();
                initialState.classList.remove('hidden');
                selectedState.classList.add('hidden');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: result.message,
                });
            }
        } catch (error) {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong. Please try again later.',
            });
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-upload mr-2"></i> Upload Document';
        }
    });
});
