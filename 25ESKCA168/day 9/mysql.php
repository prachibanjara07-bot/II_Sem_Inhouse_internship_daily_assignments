<?php
$host ="localhost";
$user ="root";
$password ="S!TAM@DAn118";
$database ="skit";
$conn = mysqli_connect($host, $user, $password, $database);
if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>
