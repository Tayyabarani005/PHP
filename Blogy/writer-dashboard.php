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

$conn = mysqli_connect($servername, $username, $password, $dbname, $port);
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Writer Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> (Writer)</h2>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Add New Post</h4>
            </div>
            <div class="card-body">
                <?php if(!empty($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>

                <form method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Title:</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content:</label>
                        <textarea name="content" id="editor" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Upload Image:</label>
                        <input type="file" name="image" accept="image/*" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        CKEDITOR.replace('editor');
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
