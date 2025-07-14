<?php
session_start();

$nameErr = $emailErr = $fnameErr = $passwordErr = $stateErr = '';
$name = $email = $fname = $password = $state = '';
function testInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $nameErr = $emailErr = $fnameErr = $passwordErr = $stateErr = '';
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['name'])) {
        $nameErr = 'Name is Required';
    } else {
        $name = testInput($_POST['name']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
        } else if (strlen($name) < 5 || strlen($name) > 30) {
            $nameErr = "Name should be between 5 and 30 characters long";
        }
    }
    if (empty($_POST['email'])) {
        $emailErr = 'Email is Required';
    } else {
        $email = testInput($_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }
    if (empty($_POST['password'])) {
        $passwordErr = 'Password is Required';
    } else {
        $password = testInput($_POST['password']);
        if (strlen($password) < 8) {
            $passwordErr = "Password must be at least 8 characters long.";
        } elseif (strlen($password) > 50) {
            $passwordErr = "Password cannot exceed 50 characters.";
        } elseif (!preg_match("/[0-9]/", $password)) {
            $passwordErr = "Password must contain at least one number.";
        } elseif (!preg_match("/[!@#$%^&*(),.?\":{}|<>]/", $password)) {
            $passwordErr = "Password must contain at least one special character.";
        }
    }

    if (empty($_POST['fname'])) {
        $fnameErr = 'Father Name is Required';
    } else {
        $fname = testInput($_POST['fname']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
            $fnameErr = "Only letters and white space allowed";
        } else if (strlen($fname) < 5 || strlen($fname) > 30) {
            $fnameErr = "Name should be between 5 and 30 characters long";
        }
    }
    if (empty($_POST["state"])) {
        $stateErr = "State is required";
    } else {
        $state = testInput($_POST["state"]);
    }

}
if ($_SERVER["REQUEST_METHOD"] == "POST" && $nameErr == "" && $fnameErr == "" && $emailErr == "" && $passwordErr == "" && $stateErr == "") {

    $_SESSION['name'] = $name;
    $_SESSION['fname'] = $fname;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $password;
    $_SESSION['state'] = $state;

    header("Location: data.php");
    exit();
}
?>

<html>

<head>
    <title>Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="min-h-screen flex items-center justify-center  bg-cover bg-center"
    style="background-image: url('img.webp');">

    <div class="w-[700px] h-[600px] flex items-center justify-center ">
        <form class="row g-3" method="post" action="connect.php">
            <h1 class="text-center font-bold text-4xl">Coolers.com </h1>
            <h1 class="text-center font-bold text-4xl">Sign Up </h1>
            <p class="text-center">(Read the terms and conditions, carefully)</p>
            <div class="col-md-6">
                <label for="inputEmail4" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="inputEmail4"
                    value="<?php echo $email; ?>"><span class="text-[#FF0000]"> *
                    <?php echo $emailErr ?></span>
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="inputPassword4"
                    value="<?php echo $password; ?>">
                <span class="text-[#FF0000]"> * <?php echo $passwordErr ?></span>
            </div>
            <div class="col-12">
                <label for="inputAddress" class="form-label">User Name</label>
                <input type="text" name="name" class="form-control" id="inputAddress" placeholder="name"
                    value="<?php echo $name; ?>"><span class="text-[#FF0000]"> * <?php echo $nameErr ?></span>
            </div>
            <div class="col-12">
                <label for="inputAddress2" class="form-label">Father Name</label>
                <input type="text" name="fname" class="form-control" id="inputAddress2" placeholder="father name"
                    value="<?php echo $fname; ?>"><span class="text-[#FF0000]"> * <?php echo $fnameErr ?></span>
            </div>
            <div class="col-md-6">
                <label for="inputCity" class="form-label">City</label>
                <input type="text" class="form-control" id="inputCity">
            </div>
            <div class="col-md-4">
                <label for="inputState" class="form-label">State</label>
                <select id="inputState" name="state" class="form-select" value="<?php echo $state; ?>">
                    <option selected>Choose...</option>
                    <option>Pakistan</option>
                    <option>Dubai</option>
                    <option>Saudi Arabia</option>
                    <option>Other</option>
                </select>
                <span class="text-[#FF0000]"> * <?php echo $stateErr ?></span>
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label">Zip</label>
                <input type="text" class="form-control" id="inputZip">
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="gridCheck">
                    <label class="form-check-label" for="gridCheck">
                        Check me out
                    </label>
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Sign up</button>
            </div>
        </form>
    </div>
</body>

</html>