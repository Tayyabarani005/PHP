<?php
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin'){
    header("Location: index.php");
    exit;
}

$conn = new mysqli('localhost','root','','blog',3307);
if($conn->connect_error) die("DB error");

$id = $_GET['id'];
$post = $conn->query("SELECT * FROM posts WHERE post_id=$id")->fetch_assoc();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_url = $_POST['image_url'];
    $conn->query("UPDATE posts SET title='$title', content='$content', image_url='$image_url' WHERE post_id=$id");
    header("Location: admin-dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Post</title></head>
<body>
<h2>Edit Post</h2>
<form method="post">
    <label>Title:</label><br>
    <input type="text" name="title" value="<?php echo $post['title']; ?>" required><br><br>

    <label>Content:</label><br>
    <textarea name="content" rows="5" cols="40" required><?php echo $post['content']; ?></textarea><br><br>

    <label>Image URL:</label><br>
    <input type="text" name="image_url" value="<?php echo $post['image_url']; ?>" required><br><br>

    <button type="submit">Save Changes</button>
</form>
</body>
</html>
