<?php
session_start();
require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$email = trim($_POST['email']);
$password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, name, phone, email, password FROM userdata WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 1) {
        $user = $res->fetch_assoc();

        if (password_verify($password, $user['password'])) {
        
            $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'phone' => $user['phone'],
                'email' => $user['email']
            ];
            header("Location: dashboard.php");
           
        } else {
            echo "Invalid password. <a href='login.php'>Try again</a>";
        }
    } else {
        echo "User not found. <a href='signup.php'>Register</a>";
    }
}
?>