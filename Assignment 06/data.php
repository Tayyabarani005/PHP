<?php
// Start output buffering
ob_start();

// Ensure no output before this
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', 'C:/xampp/htdocs/Learn_PHP/Assignment 06/php_errors.log');

// Verify error log is writable
if (!is_writable('C:/xampp/htdocs/Learn_PHP/Assignment 06/php_errors.log')) {
    file_put_contents('C:/xampp/htdocs/Learn_PHP/Assignment 06/php_errors.log', '', FILE_APPEND);
    error_log("Error log file made writable or created.");
}

// Log request details
error_log("Request: " . print_r($_POST, true) . " | Method: " . $_SERVER['REQUEST_METHOD']);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "form";
$port = 3307; // Verify this matches your MySQL port (default is 3306)

$conn = mysqli_connect($servername, $username, $password, $dbname, $port);
if (!$conn) {
    ob_end_clean();
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . mysqli_connect_error()]);
    exit;
}

mysqli_set_charset($conn, 'utf8mb4');

// Check table structure
$result = mysqli_query($conn, "SHOW TABLES LIKE 'contacts'");
if (!$result || mysqli_num_rows($result) == 0) {
    ob_end_clean();
    header('Content-Type: application/json');
    echo json_encode(['status' => 'error', 'message' => 'Table "contacts" does not exist.']);
    exit;
}
$result = mysqli_query($conn, "SHOW COLUMNS FROM contacts");
$columns = mysqli_fetch_all($result, MYSQLI_ASSOC);
error_log("Table contacts columns: " . print_r($columns, true));

$action = $_POST['action'] ?? ($_GET['action'] ?? '');

if ($action === 'create' || $action === 'update') {
    ob_end_clean();
    header('Content-Type: application/json');
    $userId = $_POST['userId'] ?? '';
    $name = $_POST['name'] ?? '';
    $fname = $_POST['fname'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    error_log("Create/Update Input: action=$action, userId=$userId, name=$name, fname=$fname, email=$email, message=$message");

    if (empty($name) || empty($fname) || empty($email) || empty($message)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
        exit;
    }

    if ($action === 'update' && $userId) {
        $stmt = $conn->prepare("UPDATE contacts SET name=?, fname=?, email=?, message=? WHERE id=?");
        if (!$stmt) {
            error_log("Update Prepare Error: " . $conn->error);
            echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
            exit;
        }
        $stmt->bind_param("ssssi", $name, $fname, $email, $message, $userId);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'User updated successfully.']);
        } else {
            error_log("Update Execute Error: " . $stmt->error);
            echo json_encode(['status' => 'error', 'message' => 'Error updating user: ' . $stmt->error]);
        }
        $stmt->close();
        exit;
    } else {
        $stmt = $conn->prepare("INSERT INTO contacts (name, fname, email, message) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            error_log("Create Prepare Error: " . $conn->error);
            echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
            exit;
        }
        $stmt->bind_param("ssss", $name, $fname, $email, $message);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'User added successfully.']);
        } else {
            error_log("Create Execute Error: " . $stmt->error);
            echo json_encode(['status' => 'error', 'message' => 'Error adding user: ' . $stmt->error]);
        }
        $stmt->close();
        exit;
    }
} elseif ($action === 'edit') {
    ob_end_clean();
    header('Content-Type: application/json');
    $id = $_POST['id'] ?? 0;
    error_log("Edit ID: $id");
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid user ID.']);
        exit;
    }
    $stmt = $conn->prepare("SELECT id, name, fname, email, message FROM contacts WHERE id=?");
    if (!$stmt) {
        error_log("Edit Prepare Error: " . $conn->error);
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        error_log("Edit Execute Error: " . $stmt->error);
        echo json_encode(['status' => 'error', 'message' => 'Execute failed: ' . $stmt->error]);
        exit;
    }
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        error_log("Edit User Data: " . print_r($user, true));
        echo json_encode($user);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found.']);
    }
    $stmt->close();
    exit;
} elseif ($action === 'delete') {
    ob_end_clean();
    header('Content-Type: application/json');
    $id = $_POST['id'] ?? 0;
    error_log("Delete ID: $id");
    if ($id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid user ID.']);
        exit;
    }
    $stmt = $conn->prepare("DELETE FROM contacts WHERE id=?");
    if (!$stmt) {
        error_log("Delete Prepare Error: " . $conn->error);
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'User deleted successfully.']);
    } else {
        error_log("Delete Execute Error: " . $stmt->error);
        echo json_encode(['status' => 'error', 'message' => 'Error deleting user: ' . $stmt->error]);
    }
    $stmt->close();
    exit;
} elseif ($action === '') {
    ob_end_clean();
    header('Content-Type: text/html');
    error_log("Loading users: GET request, Connection ID: " . mysqli_thread_id($conn));
    if (!mysqli_ping($conn)) {
        $conn = mysqli_connect($servername, $username, $password, $dbname, $port);
        mysqli_set_charset($conn, 'utf8mb4');
        error_log("Reconnected due to ping failure, New Connection ID: " . mysqli_thread_id($conn));
    }
    $sql = "SELECT id, name, fname, email, message FROM contacts";
    $result = mysqli_query($conn, $sql);
    if ($result === false) {
        $error = mysqli_error($conn);
        error_log("Query failed: $error, Connection ID: " . mysqli_thread_id($conn));
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => "Query failed: $error"]);
        exit;
    }
    $rowCount = mysqli_num_rows($result);
    error_log("Number of rows: $rowCount, Connection ID: " . mysqli_thread_id($conn));
    if ($rowCount > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td class='border px-4 py-2'>" . htmlspecialchars($row['id']) . "</td>
                    <td class='border px-4 py-2'>" . htmlspecialchars($row['name']) . "</td>
                    <td class='border px-4 py-2'>" . htmlspecialchars($row['fname']) . "</td>
                    <td class='border px-4 py-2'>" . htmlspecialchars($row['email']) . "</td>
                    <td class='border px-4 py-2'>" . htmlspecialchars($row['message']) . "</td>
                    <td class='border px-4 py-2'>
                        <button class='text-sm bg-yellow-500 text-white px-2 py-1 rounded editBtn' data-id='{$row['id']}'>Edit</button>
                        <button class='text-sm bg-red-500 text-white px-2 py-1 rounded deleteBtn' data-id='{$row['id']}'>Delete</button>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6' class='border px-4 py-2'>No users found.</td></tr>";
    }
}

mysqli_close($conn);
ob_end_clean();
?>