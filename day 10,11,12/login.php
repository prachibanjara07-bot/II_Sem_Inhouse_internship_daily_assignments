<?php
session_start(); 
include("header.php");
include("db-connect.php");
include("checkLoginError.php");

$email = $password = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Plain text password from form

    
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        
        
        if ($password === $row['password']) { 
            
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            
            
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<div class='alert alert-danger text-center'>Invalid password!</div>";
        }
    } else {
        echo "<div class='alert alert-danger text-center'>No user found with this email!</div>";
    }
}
?>
