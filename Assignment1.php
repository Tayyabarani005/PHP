<html>
    <head>
    <title>Assignment 1</title></head>
    <body>
        <form method="post">
            Enter Num 1 : <input type="text" name="num1" required/>
            Enter Operator : <input type="text" name="op" required/>
            Enter Num 2:  <input type="text" name="num2" required/>
            <input type="submit" value="Calculate">
        </form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$num1 = $_POST["num1"];
$num2 = $_POST["num2"];
$operator = $_POST["op"];
if($operator=="+"){
    $result = $num1+$num2;
}
else if($operator== "-"){
    $result = $num1-$num2;
}
else if($operator== "*"){
    $result = $num1*$num2;
}
else if($operator== "/"){
    $result = $num1/$num2;
}
else{
    echo "Invalid Entry";
}
echo "Result: $result";}
?>
    </body>
    </html>
