<?php
$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "moto";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    die("Połączenie nieudane" . mysqli_connect_error());
}
// echo "Connected succesfully";