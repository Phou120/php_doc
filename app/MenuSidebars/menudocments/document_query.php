<?php
    include_once "../../../configs/connect_db.php";
    $counter = 1;

    $search_term = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

    if (!empty($search_term)) {
        $sql = "SELECT documents.id, documents.title, documents.file_name, documents.file_path, documents.file_type, 
                documents.file_size, documents.uploaded_at, users.name as uploader_name 
                FROM documents 
                JOIN users ON documents.user_id = users.id 
                WHERE documents.title LIKE '%$search_term%'
                ORDER BY documents.id DESC";
    } else {
        $sql = "SELECT documents.id, documents.title, documents.file_name, documents.file_path, documents.file_type, 
                documents.file_size, documents.uploaded_at, users.name as uploader_name 
                FROM documents 
                JOIN users ON documents.user_id = users.id 
                ORDER BY documents.id DESC";
    }

    $result = $conn->query($sql);
    ?>