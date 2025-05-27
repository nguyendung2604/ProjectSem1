<?php
session_start();

// Kiểm tra xem người dùng có phải là admin không
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php");
//     exit();
// }

require_once 'Database.php';
$db = new Database();
$conn = $db->connect();
?>