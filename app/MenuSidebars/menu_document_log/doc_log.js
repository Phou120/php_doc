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

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    const i = Math.floor(Math.log(bytes) / Math.log(1024));
    return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
}

function getReadableFileType(mimeType) {
    const map = {
        'application/pdf': 'PDF',
        'application/msword': 'Word Document',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document': 'Word Document',
        'application/vnd.ms-excel': 'Excel Spreadsheet',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet': 'Excel Spreadsheet',
        'application/vnd.ms-powerpoint': 'PowerPoint Presentation',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation': 'PowerPoint Presentation',
        'image/jpeg': 'JPEG Image',
        'image/png': 'PNG Image',
        'image/gif': 'GIF Image',
        'image/webp': 'WebP Image',
        'image/svg+xml': 'SVG Image',
        'text/plain': 'Text File',
        'text/csv': 'CSV File',
        'application/zip': 'ZIP Archive',
        'application/x-rar-compressed': 'RAR Archive',
        'audio/mpeg': 'MP3 Audio',
        'audio/wav': 'WAV Audio',
        'video/mp4': 'MP4 Video',
        'video/x-msvideo': 'AVI Video',
        'application/json': 'JSON File',
        'text/html': 'HTML File',
        // Add more as needed
    };

    return map[mimeType.toLowerCase()] || mimeType;
}

function showLogDetails(doc) {
    Swal.fire({
        title: 'Document Access Details',
        html: `
        <div class="text-left space-y-4">
            <div class="border-b pb-4">
                <h3 class="font-bold text-lg text-gray-800">${doc.document_title}</h3>
                <p class="text-gray-600">${doc.file_name}</p>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">File Type</p>
                    <p class="font-medium">${getReadableFileType(doc.file_type)}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">File Size</p>
                    <p class="font-medium">${formatFileSize(doc.file_size)}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Action</p>
                    <p class="font-medium capitalize">${doc.action}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Access Date</p>
                    <p class="font-medium">${new Date(doc.shared_date).toLocaleString()}</p>
                </div>
            </div>
            
            <div class="pt-4 border-t">
                <p class="text-sm text-gray-500">Accessed By</p>
                <div class="flex items-center mt-2">
                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-medium mr-3">
                        ${doc.shared_by_name.charAt(0)}
                    </div>
                    <div>
                        <p class="font-medium">${doc.shared_by_name}</p>
                        <p class="text-sm text-gray-600">${doc.shared_by_email}</p>
                    </div>
                </div>
            </div>
        </div>
    `,
        showConfirmButton: false,
        showCloseButton: true,
        width: '600px'
    });
}