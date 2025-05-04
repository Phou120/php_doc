<?php
    include_once "../../../connect_db.php";
    $counter = 1;

    $search_term = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

    $sql = "
        SELECT document_shares.*, documents.title, documents.file_name, documents.file_path
        FROM document_shares
        JOIN documents ON document_shares.document_id = documents.id
        WHERE documents.title LIKE '%$search_term%' 
        OR document_shares.shared_with_email LIKE '%$search_term%'
        ORDER BY document_shares.id DESC
    ";


    $result = $conn->query($sql);
?>