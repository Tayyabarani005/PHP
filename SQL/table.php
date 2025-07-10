<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "mydb";
$port = 3307;

$conn = mysqli_connect($host, $username, $password, $database, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully!<br>";

// ✅ Create table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS MyGuests (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if (mysqli_query($conn, $sql)) {
    echo "Table MyGuests created successfully or already exists.<br>";
} else {
    echo "Error creating table: " . mysqli_error($conn);
}

// Now insert data
$insert = "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('John', 'Doe', 'john@example.com')";

if (mysqli_query($conn, $insert)) {
    echo "New record inserted successfully!";
} else {
    echo "Error inserting record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
