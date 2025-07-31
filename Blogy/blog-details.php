<?php 
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'blog';
$port = 3307;

 $conn =mysqli_connect($servername, $username, $password, $dbname, $port);
 if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
 }



// Get post id from URL
if(isset($_GET['id'])){
    $post_id = intval($_GET['id']);
    $sql = "SELECT posts.*, users.name AS author, users.image AS author_image, categories.category_name 
            FROM posts
            JOIN users ON posts.writer_id = users.user_id
            JOIN categories ON posts.category_id = categories.category_id
            WHERE posts.post_id = $post_id AND posts.status='approved'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $post = $result->fetch_assoc();
    } else {
        die("Post not found");
    }
} else {
    die("Invalid post request");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $post['title']; ?> - Blog Details</title>
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <h1>Blogy<span>.</span></h1>
      </a>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="#">Blog</a></li>
          <li><a href="#">About</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>
    </div>
  </header>
  <!-- End Header -->

  <main id="main" style="margin-top:100px;">

    <!-- ======= Blog Details Section ======= -->
    <section id="blog-details" class="blog-details">
      <div class="container" data-aos="fade-up">

        <article class="blog-details">

          <h2 class="title"><?php echo $post['title']; ?></h2>

          <div class="meta-top">
            <ul>
              <li class="d-flex align-items-center">
                <i class="bi bi-person"></i>
                <a href="#"><?php echo $post['author']; ?></a>
              </li>
              <li class="d-flex align-items-center">
                <i class="bi bi-clock"></i>
                <time datetime="<?php echo date('Y-m-d', strtotime($post['date_posted'])); ?>">
                  <?php echo date("M d, Y", strtotime($post['date_posted'])); ?>
                </time>
              </li>
              <li class="d-flex align-items-center">
                <i class="bi bi-tag"></i>
                <?php echo $post['category_name']; ?>
              </li>
            </ul>
          </div><!-- End meta top -->

          <div class="post-img">
            <img src="<?php echo $post['image_url']; ?>" alt="" class="img-fluid">
          </div>

          <div class="content">
            <p><?php echo nl2br($post['content']); ?></p>
          </div>
        </article><!-- End blog details -->

      </div>
    </section><!-- End Blog Details Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>Blogy</span></strong>. All Rights Reserved
      </div>
    </div>
  </footer>
  <!-- End Footer -->

  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/main.js"></script>
</body>

</html>
