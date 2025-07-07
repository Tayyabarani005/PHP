<?php
session_start();
?>
<html>

<head>
  <title>Data</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <h1>Name : <?php echo $_SESSION['name'] ?></h1>
  <h1>Father Name : <?php echo $_SESSION['fname'] ?></h1>
  <h1>Email : <?php echo $_SESSION['email'] ?></h1>
  <h1>Password : <?php echo $_SESSION['password'] ?></h1>
  <h1>State : <?php echo $_SESSION['state'] ?></h1>
</body>

</html>