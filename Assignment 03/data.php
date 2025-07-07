<?php
session_start();
?>
<html>

<head>
    <title>FORM DATA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#a9d6e5]">
    <h1>Name : <?php echo $_SESSION['name'] ?></h1>
    <h1>Father Name : <?php echo $_SESSION['fname'] ?></h1>
    <h1>Email : <?php echo $_SESSION['email'] ?></h1>
    <h1>Phone Number : <?php echo $_SESSION['pnum'] ?></h1>
    <h1>Gender : <?php echo $_SESSION['gender'] ?></h1>
</body>

</html>