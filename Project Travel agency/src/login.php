<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "form";
$port = 3307;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname, $port);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if user exists
    $sql = "SELECT * FROM login WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        
        header("Location: homepage.php");
      
    } else {
        echo "Invalid username or password.";
    }
}
?>
