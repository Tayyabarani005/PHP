<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: index.php");
    exit;
}

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'blog';
$port = 3307;

 $conn =mysqli_connect($servername, $username, $password, $dbname, $port);
 if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
 }

// Fetch all users
$users = $conn->query("SELECT user_id, name, email, role FROM users");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        table { border-collapse: collapse; width: 70%; margin: 20px auto; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        a { text-decoration: none; color: blue; }
    </style>
</head>
<body>
<h2 style="text-align:center;">Welcome, <?php echo $_SESSION['name']; ?> (Admin)</h2>
<p style="text-align:center;"><a href="logout.php">Logout</a></p>

<h3 style="text-align:center;">User Management</h3>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
    </tr>
    <?php while($row = $users->fetch_assoc()): ?>
    <tr>
        <td><?php echo $row['user_id']; ?></td>
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['role']; ?></td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
