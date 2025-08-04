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

$conn = mysqli_connect($servername, $username, $password, $dbname, $port);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all users
$users = $conn->query("SELECT user_id, name, email, role FROM users");

// Count pending posts
$pendingCount = $conn->query("SELECT COUNT(*) as total FROM posts WHERE status='pending'")->fetch_assoc()['total'];

// Fetch all posts with writer name
$posts = $conn->query("
    SELECT posts.post_id, posts.title, posts.status, users.name AS writer 
    FROM posts 
    JOIN users ON posts.writer_id = users.user_id
");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Admin Dashboard</a>
            <div class="d-flex">
                <span class="navbar-text text-white me-3">
                    Welcome,
                    <?php echo htmlspecialchars($_SESSION['name']); ?> (Admin)
                </span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">

        <!-- Pending Posts -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>User Management</h3>
            <a href="#posts" class="btn btn-primary position-relative">
                Pending Posts
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?php echo $pendingCount; ?>
                </span>
            </a>
        </div>

        <!-- Users Table -->
        <div class="card shadow-sm mb-5">
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = $users->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php echo $row['user_id']; ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['name']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['email']); ?>
                            </td>
                            <td><span class="badge bg-secondary">
                                    <?php echo $row['role']; ?>
                                </span></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Posts Table -->
        <div id="posts" class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Posts Management</h4>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Writer</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($p = $posts->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php echo $p['post_id']; ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($p['title']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($p['writer']); ?>
                            </td>
                            <td>
                                <?php if($p['status'] == 'pending'): ?>
                                <span class="badge bg-warning text-dark">Pending</span>
                                <?php else: ?>
                                <span class="badge bg-success">Approved</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($p['status'] == 'pending'): ?>
                                <a href="approve_post.php?id=<?php echo $p['post_id']; ?>"
                                    class="btn btn-sm btn-success">Approve</a>
                                <?php endif; ?>
                                <a href="edit_post.php?id=<?php echo $p['post_id']; ?>"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <a href="delete_post.php?id=<?php echo $p['post_id']; ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this post?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>