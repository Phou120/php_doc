<?php
    // Database connection
    include_once "../../../configs/connect_db.php";
    $counter = 1;

    // Fetch all documents
    $sql = "SELECT id, name, description FROM document_categories ORDER BY id DESC";
    $result = $conn->query($sql);