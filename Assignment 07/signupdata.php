<?php
require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = $_POST['name'];
    $phone    = $_POST['phone'];
    $email    = $_POST['email'];
    $password = $_POST['password'];


    $check = $conn->prepare("SELECT * FROM userdata WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "Email already registered. <a href='signup.php'>Try again</a>";
        exit;
    }

    $password = trim($_POST['password']); 
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO userdata (name, phone, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $phone, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "Registration successful. <a href='login.php'>Login Now</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
