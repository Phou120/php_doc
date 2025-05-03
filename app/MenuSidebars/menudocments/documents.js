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
        window.location.href = '../../../../../documentation_system/form_login.php'; 
      });
    }
  });

  

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
                            <img src="${e.target.result}" class="max-h-40 max-w-full object-contain" alt="Preview">
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

        // Get user_id from localStorage
        const userId = localStorage.getItem('user_id');
        if (!userId) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1000,
                timerProgressBar: true
            });

            Toast.fire({
                icon: 'error',
                title: 'Error',
                text: 'User not logged in. Please log in first.',
            });
            return;
        }
        formData.append('user_id', userId);

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Uploading...';

        try {
            const response = await fetch('../../../../documentation_system/save_document.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1000,
                    timerProgressBar: true
                });
    
                Toast.fire({
                    icon: 'success',
                    title: 'Document uploaded successfully!',
                }).then(() => {
                    window.location.reload();
                });
                document.getElementById('uploadForm').reset();
                initialState.classList.remove('hidden');
                selectedState.classList.add('hidden');
            } else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });
    
                Toast.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: result.message,
                });
            }
        } catch (error) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true
            });

            Toast.fire({
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



// add new category
const modal = document.getElementById("categoryModal");
const openModalBtn = document.getElementById("openModal");
const closeCategoryModalBtn = document.getElementById("closeCategoryModal");
const saveBtn = document.getElementById("saveModalCategory");

// Open modal
openModalBtn.addEventListener("click", () => {
    modal.classList.remove("hidden");
});

// Close modal with cancel button
closeCategoryModalBtn.addEventListener("click", closeCategoryModal);

// Close modal when clicking outside the modal box
modal.addEventListener("click", (e) => {
    if (e.target === modal) {
        closeCategoryModal();
    }
});

function closeCategoryModal() {
    modal.classList.add("hidden");
    clearModalFields();
}

saveBtn.addEventListener("click", () => {
    const category_name = document.getElementById("modalCategoryName").value.trim();
    const description = document.getElementById("modalCategoryDescription").value.trim();

    if (!category_name) {
        // Show a warning if the category name is empty
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true
        });

        Toast.fire({
            icon: 'warning',
            title: 'Validation Error',
            text: 'Please enter a category name.'
        });
        return;
    }

    fetch("../../../../documentation_system/app/Category/save_category.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                category_name: category_name,
                description: description
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById("category");
                const option = document.createElement("option");
                option.value = data.id ?? category_name; // Use category_name here
                option.textContent = category_name;  // Use category_name here
                option.selected = true;
                select.appendChild(option);

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true
                });

                Toast.fire({
                    icon: 'success',
                    title: 'Category saved successfully'
                });

                closeCategoryModal(); // Close the modal after success

            } else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });

                Toast.fire({
                    icon: 'error',
                    title: 'Category save error'
                });
            }
        });
});


function clearModalFields() {
    document.getElementById("modalCategoryName").value = "";
    document.getElementById("modalCategoryDescription").value = "";
}




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



// view and delete
document.addEventListener('DOMContentLoaded', function() {
    // Function to log document access
    function logDocumentAction(docId, action) {
        return fetch('../../../../documentation_system/app/document_log/log_document_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `doc_id=${docId}&action=${action}`
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    console.error('Failed to log action:', data.message);
                }
                return data;
            });
    }

    // View button click handler
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const docId = this.getAttribute('data-doc-id');
            logDocumentAction(docId, 'view');
        });
    });

    // Download button click handler
    document.querySelectorAll('.download-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const docId = this.getAttribute('data-doc-id');
            logDocumentAction(docId, 'download');
        });
    });

    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const docId = this.getAttribute('data-doc-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch(
                            '../../../../documentation_system/app/document/delete_document.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: `doc_id=${docId}`
                            })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => {
                                    throw new Error(err.message ||
                                        'Server error');
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (!data.success) {
                                throw new Error(data.message ||
                                    'Deletion failed');
                            }
                            return data;
                        })
                        .catch(error => {
                            Swal.showValidationMessage(
                                `Request failed: ${error.message}`
                            );
                            throw error;
                        });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true
                    });

                    Toast.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: 'Document deleted successfully'
                    }).then(() => {
                        location.reload();
                    });
                }
            }).catch(error => {

                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: true
                });

                Toast.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Can Not Delete This Document. because it has been shared or log'
                });
                console.error('Delete error:', error);
            });
        });
    });
});



// modal share mal
 // Open modal and set document ID
 document.querySelectorAll('.share-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const docId = btn.getAttribute('data-doc-id');
        document.getElementById('shareDocId').value = docId;
        document.getElementById('shareModal').classList.remove('hidden');
        document.getElementById('shareModal').classList.add('flex');
    });
});

function closeShareModal() {
    document.getElementById('shareModal').classList.remove('flex');
    document.getElementById('shareModal').classList.add('hidden');
    document.getElementById('shareForm').reset();
}

document.getElementById('shareForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const payload = {
        document_id: document.getElementById('shareDocId').value,
        email: document.getElementById('shareEmail').value
    };


    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        allowOutsideClick: false,
        timer: 0,
        timerProgressBar: true
    });

    Toast.fire({
        iconHtml: `<span class="swal2-icon swal2-loading" style="font-size:1.5em;"></span>`,
        title: 'Sharing Document...',
        text: 'Please wait while we send the email.',
        didOpen: () => {
            Swal.showLoading();
        }
    });

    // Perform fetch request
    fetch('../../../../documentation_system/app/document_share/save_document_share.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.text()) // Get raw text response first
        .then(text => {
            console.log('Response:', text); // Debug raw response

            // Try parsing JSON
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    });

                    Toast.fire({
                        icon: 'success',
                        title: 'Shared',
                        text: 'The document has been shared successfully.'
                    });
                    closeShareModal();
                } else {
                    throw new Error(data.message || 'Unknown error');
                }
            } catch (error) {
                console.error('JSON parse error:', error);
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });

                Toast.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to share document. Invalid server response.'
                });
            }
        })
        .catch(err => {
            console.error('Request failed:', err);
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });

            Toast.fire({
                icon: 'error',
                title: 'Network Error',
                text: 'Unable to complete the request. Please check your connection.'
            });
        });
});
