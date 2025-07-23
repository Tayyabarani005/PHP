<?php 
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'form';
$port = 3307;

$conn = mysqli_connect($servername, $username, $password, $dbname, $port);

$sql = "
SELECT s.name AS student_name, c.course AS course_name,s.id AS ID , c.id AS ID
FROM student s
LEFT JOIN course c ON s.id = c.id
";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Courses</title>
    <style>
        table {border-collapse: collapse; width: 50%; margin: 20px auto;}
        th, td {border: 1px solid black; padding: 8px; text-align: center;}
    </style>
</head>
<body>
    <h2 style="text-align:center;">Students and Their Courses</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Course Name</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['ID'] ?></td>
                <td><?= $row['student_name'] ?></td>
                <td><?= $row['course_name'] ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>

<?php $conn->close(); ?>
