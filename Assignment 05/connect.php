<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $fname = $_POST["fname"];
    $state = $_POST["state"];

    $servername = "localhost";
    $username = "root";
    $passwordd = "";
    $dbname = "form";
    $port = 3307;

    $conn = mysqli_connect($servername, $username, $passwordd, $dbname, $port);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        echo "Connection is successful<br>";
    }

    $sql = "INSERT INTO data (name, fname, email, password, state) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $name, $fname, $email, $password, $state);

    if (mysqli_stmt_execute($stmt)) {
        echo "Data inserted successfully!<br><br>";
    } else {
        echo "Error inserting data: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);

    $result = mysqli_query($conn, "SELECT * FROM data");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Display Data</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            border: 1px solid #333;
            text-align: left;
        }
        th {
            background-color: #ddd;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">User Data</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Father Name</th>
        <th>Email</th>
        <th>Password</th>
        <th>State</th>
    </tr>

    <?php
    if (isset($result) && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['fname']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['password']}</td>
                    <td>{$row['state']}</td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No data found</td></tr>";
    }

    if (isset($conn)) {
        mysqli_close($conn);
    }
    ?>
</table>

</body>
</html>
