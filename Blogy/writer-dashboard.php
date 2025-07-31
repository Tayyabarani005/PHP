<?php
session_start();
if(!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'writer' && $_SESSION['role'] != 'admin')){
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

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_url = $_POST['image_url']; // store image path directly
    $writer_id = $_SESSION['user_id'];
    $category_id = 1; // default category for now

    $stmt = $conn->prepare("INSERT INTO posts (title, content, image_url, writer_id, category_id, status) VALUES (?,?,?,?,?, 'pending')");
    $stmt->bind_param("sssii", $title, $content, $image_url, $writer_id, $category_id);
    $stmt->execute();
    $msg = "Post submitted for approval!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Writer Dashboard</title>
</head>
<body>
<h2>Welcome, <?php echo $_SESSION['name']; ?> (Writer)</h2>
<p><a href="logout.php">Logout</a></p>

<h3>Add New Post</h3>
<?php if(!empty($msg)) echo "<p style='color:green'>$msg</p>"; ?>
<form method="post">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Content:</label><br>
    <textarea name="content" rows="5" cols="40" required></textarea><br><br>

    <label>Image URL (from assets folder):</label><br>
    <input type="text" name="image_url" placeholder="assets/img/blog/blog-post-7.webp" required><br><br>

    <button type="submit">Submit</button>
</form>

</body>
</html>
