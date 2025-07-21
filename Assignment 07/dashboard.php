<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login_form.php");
    exit;
}

$user = $_SESSION['user'];
?>

<h2>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h2>
<p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
<p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

<a href="logout.php">Logout</a>
