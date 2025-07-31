<?php
session_start();
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'blog';
$port = 3307;

 $conn =mysqli_connect($servername, $username, $password, $dbname, $port);
 if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
 }

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];


    // check if email already exists
    $check = $conn->prepare("SELECT user_id FROM users WHERE email=?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0){
        $error = "Email already exists!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,?)");
        $stmt->bind_param("ssss", $name, $email, $password, $role);
        if($stmt->execute()){
           $_SESSION['user_id'] = $stmt->insert_id;
    $_SESSION['role'] = $role;
    $_SESSION['name'] = $name;

    // Redirect based on role
    if ($role == 'admin') {
        header("Location: admin-dashboard.php");
    } elseif ($role == 'writer') {
        header("Location: writer-dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit;
        } else {
            $error = "Registration failed!";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
</head>

<body>
    <h2>Register</h2>
    <?php if(!empty($error)) echo "<p style='color:red'>$error</p>"; ?>
    <form method="post">
        <label>Name:</label><input type="text" name="name" required><br>
        <label>Email:</label><input type="email" name="email" required><br>
        <label>Password:</label><input type="password" name="password" required><br>
        <label>Role:</label>
        <select name="role">
            <option value="user">User</option>
            <option value="writer">Writer</option>
            <option value="admin">Admin</option>
        </select>

        <button type="submit">Register</button>
    </form>
</body>

</html>