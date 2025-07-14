<?php
$servername = "localhost";
$username = "root";
$passwordd = "";
$dbname = "form";
$port = 3307;

$conn = mysqli_connect($servername, $username, $passwordd, $dbname, $port);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// 1. Create
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $fname = $_POST["fname"];
    $state = $_POST["state"];

    $sql = "INSERT INTO data (name, fname, email, password, state) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssss", $name, $fname, $email, $password, $state);

    if (mysqli_stmt_execute($stmt)) {
        echo "Data inserted successfully!<br><br>";
    } else {
        echo "Error inserting data: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

//2. Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_sql = "DELETE FROM data WHERE id=$id";
    mysqli_query($conn, $delete_sql);
    header("Location: connect.php");
    exit();
}
// 3-Read
$edit_mode = false;
$edit_data = [
    'id' => '',
    'name' => '',
    'fname' => '',
    'email' => '',
    'password' => '',
    'state' => ''
];

if (isset($_GET['edit'])) {
    $edit_mode = true;
    $edit_id = $_GET['edit'];
    $query = "SELECT * FROM data WHERE id=$edit_id";
    $result_edit = mysqli_query($conn, $query);
    if ($result_edit && mysqli_num_rows($result_edit) > 0) {
        $edit_data = mysqli_fetch_assoc($result_edit);
    }
}

// 4. Update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST["name"];
    $fname = $_POST["fname"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $state = $_POST["state"];

    $update_sql = "UPDATE data SET name=?, fname=?, email=?, password=?, state=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $name, $fname, $email, $password, $state, $id);
    mysqli_stmt_execute($stmt);

    header("Location: connect.php");
    exit();
}

//  5. Read
$result = mysqli_query($conn, "SELECT * FROM data");
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

        th,
        td {
            padding: 10px;
            border: 1px solid #333;
            text-align: left;
        }

        th {
            background-color: #ddd;
        }
    </style>
</head>
<h2 style="text-align: center;">
    <?php echo $edit_mode ? 'Update User' : 'Add New User'; ?>
</h2>

<form method="POST" action="connect.php" style="width: 50%; margin: auto;">
    <input type="hidden" name="id" value="<?php echo $edit_data['id']; ?>">

    <label>Name:</label>
    <input type="text" name="name" value="<?php echo $edit_data['name']; ?>" required><br><br>

    <label>Father Name:</label>
    <input type="text" name="fname" value="<?php echo $edit_data['fname']; ?>" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $edit_data['email']; ?>" required><br><br>

    <label>Password:</label>
    <input type="text" name="password" value="<?php echo $edit_data['password']; ?>" required><br><br>

    <label>State:</label>
    <input type="text" name="state" value="<?php echo $edit_data['state']; ?>" required><br><br>

    <button type="submit" name="<?php echo $edit_mode ? 'update' : 'save'; ?>">
        <?php echo $edit_mode ? 'Update' : 'Save'; ?>
    </button>
</form>

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
            <th>Actions</th>
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
                     <td>
                        <a href='connect.php?edit={$row['id']}'>Edit</a> |
                        <a href='connect.php?delete={$row['id']}' onclick=\"return confirm('Are you sure?')\">Delete</a>
                    </td>
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