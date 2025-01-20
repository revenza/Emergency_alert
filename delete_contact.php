<?php
include 'db_conn.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM contact WHERE id = '$id'");
    header('Location: index.php');
}
