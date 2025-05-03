<?php
    include_once "../../../connect_db.php";

    // Define helper functions safely
    if (!function_exists('formatSize')) {
        function formatSize($bytes) {
            $units = ['B', 'KB', 'MB', 'GB'];
            for ($i = 0; $bytes >= 1024 && $i < count($units) - 1; $i++) {
                $bytes /= 1024;
            }
            return round($bytes, 1) . ' ' . $units[$i];
        }
    }

    if (!function_exists('timeAgo')) {
        function timeAgo($datetime) {
            $timestamp = strtotime($datetime);
            $diff = time() - $timestamp;

            if ($diff < 60) return 'Just now';
            elseif ($diff < 3600) return floor($diff / 60) . ' mins ago';
            elseif ($diff < 86400) return floor($diff / 3600) . ' hrs ago';
            elseif ($diff < 604800) return floor($diff / 86400) . ' days ago';
            else return date("M d, Y", $timestamp);
        }
    }

    if (!function_exists('getFriendlyType')) {
        function getFriendlyType($ext) {
            switch (strtolower($ext)) {
                case 'pdf': return 'PDF File';
                case 'doc': case 'docx': return 'Word Document';
                case 'xls': case 'xlsx': return 'Excel File';
                case 'ppt': case 'pptx': return 'PowerPoint';
                case 'jpg': case 'jpeg': case 'png': return 'Image';
                default: return strtoupper($ext) . ' File';
            }
        }
    }

    // Fetch recent documents
    $sql = "SELECT id, title, file_name, file_path, file_type, file_size, uploaded_at 
            FROM documents 
            ORDER BY uploaded_at DESC 
            LIMIT 4";
    $result = $conn->query($sql);

    $user = "SELECT * FROM users ORDER BY id ASC LIMIT 4";
    $result2 = $conn->query($user);
    ?>