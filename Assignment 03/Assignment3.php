<html>

<head>
    <title>Assignment 3</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#a9d6e5] min-h-screen flex items-center justify-center">
    <?php
    $nameErr = $fnameErr = $emailErr = $pnumErr = $genderErr = "";
    $name = $fname = $email = $pnum = $gender = "";
    function testInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        $nameErr = $fnameErr = $emailErr = $pnumErr = $genderErr = "";
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_POST['name'])) {
            $nameErr = "Name is required";
        } else {
            $name = testInput($_POST["name"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
                $nameErr = "Only letters and white space allowed";
            }
        }
        if (empty($_POST['fname'])) {
            $fnameErr = "Father Name is required";
        } else {
            $fname = testInput($_POST["fname"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
                $fnameErr = "Only letters and white space allowed";
            }
        }
        if (empty($_POST['email'])) {
            $emailErr = "Email is required";
        } else {
            $email = testInput($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }
        if (empty($_POST["pnum"])) {
            $pnumErr = "Phone Number is required";
        } else {
            $pnum = testInput($_POST["pnum"]);
            if (!preg_match("/^[0-9]{11}$/", $pnum)) {
                $pnumErr = "Invalid phone number";
            }
        }
        if (empty($_POST["gender"])) {
            $genderErr = "Gender is required";
        } else {
            $gender = testInput($_POST["gender"]);
        }
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $nameErr == "" && $fnameErr == "" && $emailErr == "" && $pnumErr == "" && $genderErr == "") {

        session_start();
        $_SESSION['name'] = $name;
        $_SESSION['fname'] = $fname;
        $_SESSION['email'] = $email;
        $_SESSION['pnum'] = $pnum;
        $_SESSION['gender'] = $gender;
        $_SESSION['comment'] = $_POST['comment'];

        header("Location: data.php");
        exit();
    }


    ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <h1 class="font-bold text-[#012a4a] p-3 text-center text-3xl">Fill Out this... 🥳</h1>
        <div class="bg-[#468faf] w-[600px] h-[500px] rounded-3xl p-5">
            <span class="text-[#012a4a]">Name : </span><input placeholder="Enter your name" type="text" name="name"
                class='text-[#012a4a] rounded border-none mt-5' value="<?php echo $name; ?>"><span
                class="text-[#FF0000]"> *
                <?php echo $nameErr ?></span><br>
            <span class="text-[#012a4a]">Father Name : </span><input placeholder="Enter your father name" type="text"
                name="fname" class='text-[#012a4a] rounded border-none mt-5' value="<?php echo $fname; ?>"><span
                class="text-[#FF0000]"> *
                <?php echo $fnameErr ?></span><br>
            <span class="text-[#012a4a]">Email : </span><input placeholder="Enter your email" type="text" name="email"
                class='text-[#012a4a] rounded border-none mt-5' value="<?php echo $email; ?>"><span
                class="text-[#FF0000]"> *
                <?php echo $emailErr ?></span><br>
            <span class="text-[#012a4a]">Phone Number : </span><input type="text" name="pnum"
                class='text-[#012a4a] rounded border-none mt-5' value="<?php echo $pnum; ?>"><span
                class="text-[#FF0000]"> *
                <?php echo $pnumErr ?></span><br>

            <span class="text-[#012a4a]">Gender : </span><input class='text-[#012a4a] rounded border-none mt-5'
                type="radio" name="gender" value="Female" <?php if ($gender == "Female")
                    echo "checked"; ?>><span
                class='text-[#012a4a]'>Female</span>
            <input type="radio" name="gender" value="Male" <?php if ($gender == "Male")
                echo "checked"; ?>><span
                class='text-[#012a4a]'>Male</span>
            <input type="radio" name="gender" value="Other" <?php if ($gender == "Other")
                echo "checked"; ?>><span
                class='text-[#012a4a]'>other</span><span class="text-[#FF0000]"> *
                <?php echo $genderErr ?></span><br>
            <span class="text-[#012a4a] mt-10">Comment : </span><textarea class='text-[#012a4a]' name="comment" rows="5"
                cols="40" id=""></textarea>
            <div class="justify-center items-center flex">
                <div
                    class="justify-center items-center flex w-full max-w-[200px] bg-[#012a4a] rounded-xl p-2 h-10 mt-5">
                    <input type="submit"
                        class="text-white  text-center p-2 px-6  rounded border-none p-2 hover:bg-[#89c2d9] w-full max-w-[200px] cursor-pointer"
                        value="Submit">
                </div>
            </div>


        </div>

        </div>
    </form>
</body>

</html>