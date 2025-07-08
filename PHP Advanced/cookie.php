<?php
$cookie_name = 'user';
$cookie_value = 'tayyaba rani';
setcookie($cookie_name, $cookie_value, time() +(86400),'/');
?>
<html>
    <head></head>
    <body>
        <?php
        echo $_COOKIE[$cookie_name];
        ?>
    </body>
</html>