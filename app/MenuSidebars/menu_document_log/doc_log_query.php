<?php
        include_once "../../../connect_db.php";

        $counter = 1;

        // Initialize variables
        $search_term = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
        $status_filter = isset($_GET['status']) ? $conn->real_escape_string($_GET['status']) : '';
        $date_filter = isset($_GET['date']) ? $conn->real_escape_string($_GET['date']) : '';
        $result = null;

        // SQL query with JOINs
        $sql = "SELECT 
                    dal.id AS log_id,
                    dal.accessed_at AS shared_date,
                    d.id AS document_id,
                    d.title AS document_title,
                    d.file_name,
                    d.file_path,
                    d.file_type,
                    d.file_size,
                    d.is_public,
                    d.uploaded_at AS document_created,
                    shared_by.id AS shared_by_id,
                    shared_by.name AS shared_by_name,
                    shared_by.email AS shared_by_email,
                    dal.action
                FROM document_access_logs dal
                JOIN documents d ON dal.document_id = d.id
                JOIN users shared_by ON dal.user_id = shared_by.id
                WHERE 1=1";

        // Add search filter
        if (!empty($search_term)) {
            $sql .= " AND (
                d.title LIKE '%$search_term%' OR 
                d.file_name LIKE '%$search_term%' OR 
                shared_by.name LIKE '%$search_term%' OR 
                shared_by.email LIKE '%$search_term%'
            )";
        }

        if (!empty($status_filter) && in_array($status_filter, ['view', 'download', 'delete'])) {
            $sql .= " AND dal.action = '$status_filter'";
        }

        // Date filter
        if (!empty($date_filter)) {
            $sql .= " AND DATE(dal.accessed_at) = '$date_filter'";
        }

        // Order results by most recent access
        $sql .= " ORDER BY dal.accessed_at DESC";

        // Execute query
        $result = $conn->query($sql);

        // Handle query error
        if (!$result) {
            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => "Database query failed: " . $conn->error
            ]);
            exit;
        }

        // Fetch results into array
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Get stats for cards
        $stats = [
            'total' => $result->num_rows,
            'views' => 0,
            'downloads' => 0,
            'deletes' => 0
        ];
        
        foreach ($data as $row) {
            if ($row['action'] == 'view') $stats['views']++;
            if ($row['action'] == 'download') $stats['downloads']++;
            if ($row['action'] == 'delete') $stats['deletes']++;
        }

        // Close database connection
        $conn->close();
        
        // Function to determine file type badge
        function getFileTypeBadge($file_name, $file_type) {
            $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'tiff'])) {
                return ['class' => 'file-image', 'icon' => 'fa-image', 'text' => strtoupper($extension), 'color' => 'text-blue-500', 'bg' => 'bg-blue-100'];
            } elseif ($extension === 'pdf') {
                return ['class' => 'file-pdf', 'icon' => 'fa-file-pdf', 'text' => 'PDF', 'color' => 'text-red-500', 'bg' => 'bg-red-100'];
            } elseif (in_array($extension, ['doc', 'docx'])) {
                return ['class' => 'file-doc', 'icon' => 'fa-file-word', 'text' => 'DOC', 'color' => 'text-blue-600', 'bg' => 'bg-blue-100'];
            } elseif (in_array($extension, ['xls', 'xlsx', 'csv'])) {
                return ['class' => 'file-xls', 'icon' => 'fa-file-excel', 'text' => 'XLS', 'color' => 'text-green-600', 'bg' => 'bg-green-100'];
            } elseif (in_array($extension, ['ppt', 'pptx'])) {
                return ['class' => 'file-ppt', 'icon' => 'fa-file-powerpoint', 'text' => 'PPT', 'color' => 'text-orange-500', 'bg' => 'bg-orange-100'];
            } elseif (in_array($extension, ['zip', 'rar', '7z', 'tar', 'gz'])) {
                return ['class' => 'file-zip', 'icon' => 'fa-file-archive', 'text' => strtoupper($extension), 'color' => 'text-yellow-500', 'bg' => 'bg-yellow-100'];
            } elseif (in_array($extension, ['mp3', 'wav', 'ogg', 'aac', 'flac'])) {
                return ['class' => 'file-audio', 'icon' => 'fa-file-audio', 'text' => strtoupper($extension), 'color' => 'text-purple-500', 'bg' => 'bg-purple-100'];
            } elseif (in_array($extension, ['mp4', 'mov', 'avi', 'mkv', 'wmv'])) {
                return ['class' => 'file-video', 'icon' => 'fa-file-video', 'text' => strtoupper($extension), 'color' => 'text-indigo-500', 'bg' => 'bg-indigo-100'];
            } elseif (in_array($extension, ['html', 'css', 'js', 'php', 'py', 'java', 'cpp', 'c', 'h', 'json', 'xml'])) {
                return ['class' => 'file-code', 'icon' => 'fa-file-code', 'text' => strtoupper($extension), 'color' => 'text-teal-500', 'bg' => 'bg-teal-100'];
            } elseif (in_array($extension, ['txt', 'rtf', 'md', 'log'])) {
                return ['class' => 'file-text', 'icon' => 'fa-file-alt', 'text' => strtoupper($extension), 'color' => 'text-gray-500', 'bg' => 'bg-gray-100'];
            } else {
                return ['class' => 'file-other', 'icon' => 'fa-file', 'text' => strtoupper($extension ?: 'FILE'), 'color' => 'text-gray-400', 'bg' => 'bg-gray-100'];
            }
        }
        
        
        // Helper function to format file size
        function formatFileSize($bytes) {
            if ($bytes == 0) return '0 Bytes';
            $k = 1024;
            $sizes = ['Bytes', 'KB', 'MB', 'GB'];
            $i = floor(log($bytes) / log($k));
            return number_format($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
        }
    ?>