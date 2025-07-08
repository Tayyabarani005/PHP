<?php
echo 'Using Include';
echo include 'date_time.php'; //same as requrie only the differene is that if file loading fails them the code in current files not stop execution
echo 'Using Require';
echo require 'date_time.php'; // if files loading fails execution stop
?>