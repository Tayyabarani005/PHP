<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_FILES['image'])) {
    echo '<pre>';
    print_r($_FILES);
    echo '</pre>';
}
$file_name = $_FILES['image']['name'];
$file_size = $_FILES['image']['size'];
$file_tmp = $_FILES['image']['tmp_name'];
$file_type = $_FILES['image']['type'];
move_uploaded_file($file_tmp, 'uploads/'. $file_name);}
?>

<html>

<head>
    <title></title>
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="image"><br><br>
        <input type="submit">
    </form>
</body>

</html>