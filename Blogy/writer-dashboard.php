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
    $writer_id = $_SESSION['user_id'];
    $category_id = 1; // default category

    // Handle image upload
    $targetDir = "assets/img/blog/";
    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;

    if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)){
        $image_url = $targetFilePath;
    } else {
        $image_url = ""; 
    }

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
    <h2>Welcome,
        <?php echo $_SESSION['name']; ?> (Writer)
    </h2>
    <p><a href="logout.php">Logout</a></p>

    <h3>Add New Post</h3>
    <?php if(!empty($msg)) echo "<p style='color:green'>$msg</p>"; ?>
    <form method="post" enctype="multipart/form-data">
        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Content:</label><br>
        <textarea name="content" id="editor" required></textarea><br><br>
        <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
        <script>
            CKEDITOR.replace('editor');
        </script>

        <label>Upload Image:</label><br>
        <input type="file" name="image" accept="image/*" required><br><br>


        <button type="submit">Submit</button>
    </form>

</body>

</html>