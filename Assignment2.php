<html>

<head>
    <title>Assignment 2</title>
</head>
<?php
$num1Err = $num2Err = '';
$num1 = $num2 = '';
$isValid = true;
function testInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $num1 = $num2 = '';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isValid = true;
    if (empty($_POST["num1"])) {
        $num1Err = "Enter Number Compulsory";
        $isValid = false;
    } else {
        $num1 = testInput(($_POST['num1']));
        if (!is_numeric($num1)) {
            $num1Err = 'Only numbers are allowed';
            $isValid = false;
        }
    }
    if (empty($_POST["num2"])) {
        $num2Err = "Enter Number Compulsory";
        $isValid = false;
    } else {
        $num2 = testInput(($_POST['num2']));
        if (!is_numeric($num2)) {
            $num2Err = 'Only numbers are allowed';
            $isValid = false;
        }
    }
    $operator = testInput($_POST["op"]);
}
?>

<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        Enter Num 1 : <input type="text" name="num1" style="margin-top: 15px;" value="<?php echo $num1; ?>" /><span
            style="color:red;">*<?php echo $num1Err ?></span><br>
        Enter Num 2: <input type="text" name="num2" style="margin-top: 15px;" value="<?php echo $num2; ?>" /><span
            style="color:red;">*<?php echo $num2Err ?></span><br>
        Select Operator : <select style="margin-top: 15px;" name="op" id="">
            <option value="Choose Operator">Choose Operator</option>
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
        </select><br>
        <input style="margin-top: 15px;" type="submit" value="Calculate">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $operator = $_POST["op"];
        if ($isValid) {
            switch ($operator) {
                case '+':
                    $result = $num1 + $num2;
                    break;
                case '-':
                    $result = $num1 - $num2;
                    break;
                case '*':
                    $result = $num1 * $num2;
                    break;
                case '/':
                    $result = $num1 / $num2;
                    break;

                default:
                    $result = "Invalid Entry";

            }
            echo "Result: $result";

        }
    }
    ?>
</body>

</html>