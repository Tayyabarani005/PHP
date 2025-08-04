<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: index.php");
    exit;
}

$conn = new mysqli('localhost','root','','blog',3307);
if($conn->connect_error) die("DB error");

$id = $_GET['id'];
$conn->query("UPDATE posts SET status='approved' WHERE post_id=$id");

header("Location: admin-dashboard.php");
exit;
?>
