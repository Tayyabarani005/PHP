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

// Count pending posts
$pendingCount = $conn->query("SELECT COUNT(*) as total FROM posts WHERE status='pending'")->fetch_assoc()['total'];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
    <style>
        table {
            border-collapse: collapse;
            width: 70%;
            margin: 20px auto;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
            color: blue;
        }
    </style>
</head>

<body>
    <h2 style="text-align:center;">Welcome,
        <?php echo $_SESSION['name']; ?> (Admin)
    </h2>
    <p style="text-align:center;">
        <a href="#posts">Pending Posts <span style="color:white; background:red; padding:3px 8px; border-radius:10px;">
                <?php echo $pendingCount; ?>
            </span></a>
    </p>

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
            <td>
                <?php echo $row['user_id']; ?>
            </td>
            <td>
                <?php echo $row['name']; ?>
            </td>
            <td>
                <?php echo $row['email']; ?>
            </td>
            <td>
                <?php echo $row['role']; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>


    <?php
// Fetch all posts with writer name
$posts = $conn->query("
  SELECT posts.post_id, posts.title, posts.status, users.name AS writer 
  FROM posts 
  JOIN users ON posts.writer_id = users.user_id
");
?>
    <h3 style="text-align:center;">Posts Management</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Writer</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while($p = $posts->fetch_assoc()): ?>
        <tr>
            <td>
                <?php echo $p['post_id']; ?>
            </td>
            <td>
                <?php echo $p['title']; ?>
            </td>
            <td>
                <?php echo $p['writer']; ?>
            </td>
            <td>
                <?php echo $p['status']; ?>
            </td>
            <td>
                <?php if($p['status'] == 'pending'): ?>
                <a href="approve_post.php?id=<?php echo $p['post_id']; ?>">Approve</a>
                <?php endif; ?>
                | <a href="edit_post.php?id=<?php echo $p['post_id']; ?>">Edit</a>
                | <a href="delete_post.php?id=<?php echo $p['post_id']; ?>"
                    onclick="return confirm('Delete this post?');">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

</body>

</html>