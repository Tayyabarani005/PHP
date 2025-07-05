<html>
<!-- form handling and validation -->

<head>
    <title>Form Handling</title>
</head>

<body>
    <?php
    $name = $email = "";
    $nameErr = $emailErr = "";
    $formSubmitted = ($_SERVER['REQUEST_METHOD'] === 'POST');;
    function testInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    if ($formSubmitted) {
       
        if (empty($_POST['name'])) {
            $nameErr = 'Name is Mandatory';
        } else {
            $name = testInput($_POST['name']);
        }
        if (empty($_POST['email'])) {
            $emailErr = 'Email is Mandatory';
        } else {
            $email = testInput($_POST['email']);
        }
    }
    ?>
    <div class="container" style="width: 50%; margin: 0 auto;">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
            Name : <input type="text" name="name" placeholder="Enter your name" style="margin-top:15px ;padding:3px; "
                value="<?php echo $name; ?>"><?php if ($formSubmitted && !empty($nameErr)) {
                       echo '<span style="color:red;">* ' . $nameErr . '</span>';
                   } ?>
            <br>
            Email : <input type="text" name="email" placeholder="Enter your email"
                style="margin-top: 15px; padding: 3px;" value="<?php echo $email; ?>"><?php if ($formSubmitted && !empty($emailErr)) {
                       echo '<span style="color:red;">* ' . $emailErr . '</span>';
                   } ?>
            <br>
            <input type="submit" style="margin-top:15px ;padding:3px;">
    </div>
    </form>

</body>

</html>