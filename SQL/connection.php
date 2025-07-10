<?php

//ways to connect to mysql database
//1- sqli extension
//2-PDO
//Connecting to data base
$servername = "localhost";
$username = "root";
$password = "";
$port = 3307;        

//Create a connection
$conn = mysqli_connect($servername, $username, $password, "", $port);
echo 'Connection was successfull';
//Die if connection was not successfull
if(!$conn){
    die ('Connection failed'.mysqli_connect_error());
}//connect a db
$sql = "CREATE DATABASE myDB";
$res = mysqli_query($conn,$sql);
echo 'The res is : ';
echo var_dump($res);
echo '<br>';


?>