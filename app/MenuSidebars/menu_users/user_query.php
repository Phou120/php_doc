<?php
    include_once '../../../configs/connect_db.php';
    $counter = 1;
    $sql = "SELECT id, name, email, created_at FROM users ORDER BY id DESC";
    $result = $conn->query($sql);
?>